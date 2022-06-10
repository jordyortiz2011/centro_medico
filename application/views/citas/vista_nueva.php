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
                        <a href="http://app.sis.gob.pe/SisConsultaEnLinea/Consulta/frmConsultaEnLinea.aspx" target="_blank"><button >Consultar SIS</button></a>
                    </div>
                  <!--<div class="dropdown">
                    <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                    <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                  </div> -->
                </div>
                <div class="card-header d-flex align-items-center">
                  <h2>Registrar nueva cita </h2>

                </div>
                <div class="card-body">

                    <!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                    <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?>
                    <br>
                        <h4>Datos del Paciente: </h4>
                        <div class="row " style="border: 1px solid #C9DAE1;">


                                <!-- Columna Izquierda -->
                                <div class="col-12 col-md-6" >
                                    <form id="form_buscar_paciente">
                                    <div class="form-group">
                                        <label for="select_tipo">Tipo Doc <span class="text-red">(*) </span></label>
                                        <div>
                                            <select class="select2 form-control form-control-lg" id="select_tipo" name="select_tipo"  >
                                                <option value="1"> DNI</option>
                                                <option value="2"> Nro Formato</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="formGroupExampleInput2">Documento <span class="text-red">(*) </span></label>
                                        <div>
                                            <input type="text" class="form-control" id="text_buscar" name="text_buscar" autocomplete="on" placeholder="Ingrese DNI o Nro Formato ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" id="btn_buscar_paciente" class="btn btn-info" data-placement="top" data-html="true" title="Buscar Estudiante"  >
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                    </form>
                                </div>

                                <!-- Columna Derecha -->
                                <div class="col-12 col-md-6" >
                                    <div class="form-group">
                                        <span class="font-weight-bold">Apellidos y Nombres </span>
                                        <span id="span_apellidos" > </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Sexo: </span>
                                        <span id="span_sexo"> </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Fecha Nacimiento: </span>
                                        <span id="span_fecha_naci" > </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Edad: </span>
                                        <span id="span_edad" > </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Historia clínica: </span>
                                        <span id="span_historia" ></span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Posee  SIS: </span>
                                        <span id="span_posee_sis" ></span>
                                    </div>
                                    <div class="form-group">
                                        <span class="font-weight-bold">Establecimiento de salud: </span>
                                        <span id="span_eess" ></span>
                                    </div>

                                </div>
                        </div>
                        <br>
                        <h4 class="seccion_citas d-non" >Datos de la cita: </h4>
                        <div class="row seccion_citas d-non" id="bloque_citas" style="border: 1px solid #C9DAE1; padding-top: 1em; ">

                            <!-- Columna Izquierda -->
                            <div class="col-12 col-md-4" >
                                <form id="form_cita" action="<?= base_url('citas/nueva/procesa') ?>" method="POST">
                                    <input type="hidden" name="hidden_id_paciente" id="hidden_id_paciente"  >
                                    <div class="form-group">
                                        <label for="select_especialidad">Especialidad <span class="text-red">(*) </span></label>
                                        <div>
                                            <select class="select2 form-control form-control-lg" style="width: 100%;" id="select_especialidad" name="select_especialidad"   >
                                                <option value="">Seleccione</option>
                                                <?php
                                                    foreach ($lst_especialidades as $especialidad) {
                                                        echo "<option value='$especialidad->id_especialidad'>$especialidad->nombre_espe</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="select_profesionales">Profesional <span class="text-red">(*) </span></label>
                                        <div>
                                            <select class="select2 form-control form-control-lg" id="select_profesionales" name="select_profesionales"  >
                                                <option value="">Seleccione</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="text_fechacita">Fecha cita <span class="text-red">(*) </span></label>
                                        <div>
                                            <input type="text" class="form-control" id="text_fechacita" name="text_fechacita" autocomplete="off" placeholder="">
                                        </div>
                                    </div>


                                </form>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-12 col-md-8" id="bloque_horarios_profesionales" >
                                <!-- <div class="form-group horario_flotante" >
                                   <h5>LUIS, VELA</h5>
                                        + Lun 07:00 a 13:00hrs : Consultorio 1<br>
                                        + Mie 07:00 a 13:00hrs : Consultorio 1<br>
                                        + Jue 07:00 a 13:00hrs : Consultorio 1<br>
                                </div> -->
                            </div>
                        </div>
                        <br>


                    <div class="form-group text-center">
                       <!-- <button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                        </button>-->
                        <button type="submit" class="btn btn-outline-primary" id="btn_form_cita"  value="listar">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                        </button>
                    </div>




                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
        </div>
      </section>

<!-- 3 =============       FOOTER          ========================= -->


<script>
    var FECHA_HOY  = '<?= $fecha_hoy ?>';
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
        var NUM_CITA =  <?php echo $this->session->flashdata('num_cita') ?>;
        swal( 'Registro Correcto','Su número de cita es: ' + NUM_CITA, "success");
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