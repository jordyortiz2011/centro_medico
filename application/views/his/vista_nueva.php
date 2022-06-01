<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'FUA nueva',
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
                                                //Subida de ficheros
                                                //dataTables
                                              //'librerias/datatable/datatables.min.css'  , 
                                              'librerias/datatable/bootstrap/dataTables.bootstrap.css' ,                                 
                                               'librerias/sweetalert/sweetalert.css' ,

                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'FUA' => '' , 'Nueva' => '#' ),
                        'titulo'        => 'HISTORIAL' ,
                        'titulo_icono'  => 'fa fa-file-text-o',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  

<style>
    .form-control{
        padding: 5px 10px !important;
    }
</style>
<style>
    .thumb {
        flex: 1;
        height: 100%;
    }
</style>

<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="">
        <div class="container-fluid card-header">
          <div class="card-header d-flex align-items-center">
                 <img src="<?= base_url('public/assets/img/logo_nuevo_sis_pequeno.jpg') ?>" width="227px"  height="51px">  &nbsp;
                 <h3>Seguro Integral de Salud </h3>
          </div>
          <div class=" row col-md-12 "  >


                  <div class="tabbable">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                              <li class="nav-item">
                                                <a class="nav-link active" id="hisdelante-tab" data-toggle="tab" href="#hisdelante" role="tab" aria-controls="hisdelante" aria-selected="true">HIS ADELANTE</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="hisatras-tab" data-toggle="tab" href="#hisatras" role="tab" aria-controls="hisatras" aria-selected="false">HIS ATRAS</a>
                                              </li>
                                            
                                            </ul>

                                          <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="hisdelante" role="tabpanel" aria-labelledby="hisdelante-tab">
                                     <div class="form-group col-lg-9 text-center row" >
                                      <br>
                                      <table class="table table-bordered">
                                        <tr  style="background-color: #d0d0d0d0" class="text-center">
                                          <td colspan="1">AÑO</td>
                                          <td colspan="1">MES</td>
                                          <td colspan="5">NOMBRE DE ESTABLECIMIENTO DE SALUD (IPRESS)</td>
                                          <td colspan="">UNIDAD PRODUCTORA DE SERVICIOS (UPSS)</td>
                                          <td colspan="3">NOMBRE DEL RESPOSABLE DE LA ATENCIÓN</td>
                                        </tr>

                                        <tr class="text-center">
                                          <td colspan="1"></td>
                                          <td colspan="1"></td>
                                          <td colspan="5"></td>
                                          <td colspan="1"></td>
                                          <td colspan="1" style="background-color: #d0d0d0d0">DNI</td>
                                          <td colspan="1"></td>
                                          <td colspan="3"></td>
                                        </tr>

                                      </table>

                                    <table class="table table-bordered" style=" display: block; overflow-x: auto;">
                                        <tr class="text-center">
                                          <td rowspan="3" colspan="1">DIA</td>
                                          <td rowspan="2" colspan="1">DNI</td>
                                          <td colspan="1">FINANC.</td>
                                          <td colspan="1">DISTRITO DE PROCEDENCIA</td>
                                          <td rowspan="3" colspan="1" style="background-color: #d0d0d0d0">EDAD</td>
                                          <td rowspan="3" colspan="1">SEXO</td>
                                          <td rowspan="3" colspan="1">PERIMETRO CEFALICO Y ABDOMINAL</td>
                                          <td rowspan="3" colspan="1">EVALUACION ANTROPOMETRICA HEMOGLOBINA</td>
                                          <td rowspan="3" colspan="1">ESTABLECIMIENTO</td>
                                          <td rowspan="3" colspan="1">SERVICO</td>
                                          <td rowspan="3" colspan="1">DIAGNÓSTICO MOTIVO DE CONSULTA Y/O ACTIVIDAD DE SALUD</td>
                                          <td rowspan="2" colspan="1">TIPO DE DIAGNÓSTICO</td>
                                          <td rowspan="3" colspan="1">LAB</td>
                                          <td rowspan="3" colspan="1">CÓDIGO CIE/CPT</td>
                                        </tr>

                                         <tr class="text-center">
                                          <td colspan="1">10</td>
                                          <td colspan="1">12</td>
                                          <td colspan="1">P</td>
                                          <td colspan="1">D</td>
                                          <td colspan="1">R</td>
                                        </tr>

                                          <tr class="text-center">
                                          <td colspan="1">HISTORIA CLINICA</td>
                                          <td colspan="1">ETNIA</td>
                                          <td colspan="1">CENTRO POBLADO(*)</td>
                                        </tr>
                                   </table>

                                      

                                    </div>
                                              





                                            </div>
                                            <div class="tab-pane fade" id="hisatras" role="tabpanel" aria-labelledby="hisatras-tab">2</div>
                                          
                                          </div>


                                           
                                                    <div class="space-12"></div>

                   </div>

                            
               </div>
                                            
            </div>

          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12">
              <div class="line-chart-example card">
                <div class="card-close">

                </div>
                

                  <div class="card-body">
                    
                      


                   <div class="row">
                    

           
            

          

                      <?php if($auth_level == 3)  { ?>

                        <?php } ?>

                  <?php if($auth_level == 3)  { ?>
                      <div class="row justify-content-md-center">

                          <div class="card text-center" style="width: 20em;">
                              <h4 >Foto</h4>

                              <div  id="image-holder" style="margin: 0px auto; width: 200px; height: 200px;justify-content: center; display: flex;  flex-direction: row;" >
                                  <img class="card-img-top img-thumbnail" src="<?= base_url('public/img/fotos_solicitud/solicitud_defecto_icono.png') ?>" alt="Foto" width="200px" height="300px" style=" margin: 0px auto;">
                              </div>

                              <input type="file" name="archivo" id="archivo" style="display: inline-block; color: transparent;"  class="btn btn-default" />

                              <div id="bloque_barraProgreso_foto" class="row d-none">
                                  <div class="col-md-7 " style="display: inline-block;    " >
                                      <progress id="barra_de_progreso" value="0" max="100" style="width: 16em; margin-left: 1em;"  ></progress>
                                  </div>
                              </div>
                              <div class="card-block">
                                  <a id="boton_subir_imagen" class="btn btn-info" title="Subir foto" >
                                      <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                  </a>
                              </div>
                              <div class="card-footer">
                                  <div id="bloque_respuesta_foto" class="alert  alert-dismissible fade show" role="alert">
                                      <span id="mensaje_respuesta_foto"></span>
                                  </div>
                              </div>
                          </div>

                      </div>
                 <?php } ?>

                  <br> <br>
                    <div class="text-center col-lg-12" >
                        <button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                        </button>
                        <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                        </button>
                    </div>
                    </form>

                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
            </div>
        </div>


      </section>


<script>
    var FECHA_18_MENOS = '<?= $hoy_menos_18_anos ?>';
</script>

<?php
$version = @config_item(version_archivos);
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						  //Select2
                    					  'librerias/select2/dist/js/select2.js',
                    					  //popper (btn agregar colegio)
                    					  //'librerias/popper/popper.min_1.12.9.js',
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
                                        //numeric
                                        'librerias/numeric/jquery.numeric.min.js',
                                        //Calcular edad automaticamente
                                        'librerias/Calculate-Age-Birthday-Ager/ager.js',
                                        //Combobox zonas (Departamentos, provincias, distritos)
                                        'recursos/solicitud/js/nueva_solicitud_combobox_zonas.js?'.$version,
                                        //Noty
                                        'librerias/noty-master/lib/noty.js',
                                        //tablas
                                        'librerias/datatable/jquery.dataTables.min.js',
                                        'librerias/datatable/bootstrap/dataTables.bootstrap.min.js' ,


                                        //script principal
                    				          	  'recursos/solicitud/js/nueva_solicitud.js?4.'.$version,
                                          'recursos/solicitud/js/nueva_solicitud_autocalcular.js?4.'.$version ,
                                          'recursos/solicitud/js/nueva_solicitud_webservice.js?4.'.$version,

                                        //Subida de ficheros
                                        'recursos/solicitud/js/upload.js',
                                        'recursos/solicitud/js/subida_ficheros.js',
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
<?php } else if ( isset($estado_registro) &&  $estado_registro == 'registrar_error' ){ ?>
    <script>
        swal( 'Error al registrar','', "error");
    </script>
<?php } ?>
