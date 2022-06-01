<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Registrar Horario',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                //FullCalendar
                                                'librerias/fullcalendar-3.10.0/fullcalendar.min.css',
                                                'librerias/fullcalendar-3.10.0/fullcalendar.min.css',
                                                'librerias/fullcalendar-3.10.0/bootstrap.min.css',
                                                'recursos/gestores/horarios/css/mi_fullcalendar.css',
                                                //FullCalendar - validacion
                                                'librerias/fullcalendar-3.10.0/bootstrapValidator.min.css' ,
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
                        'navegacion'    => array ('Gestores'  => '' , 'Horarios' => '' , 'Registrar' => '#' ),
                        'titulo'        => 'Registrar Horario' ,
                        'titulo_icono'  => 'fa fa-table',
                        'descripcion'   => 'Registra los horarios de los profesionales por consultorios'
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->
<link href="<?=base_url('public/librerias/fullcalendar-3.10.0/fullcalendar.print.css') ?> "  rel='stylesheet' media='print' />
<link href="<?=base_url('public/recursos/gestores/horarios/css/mi_impresion') ?> "  rel='stylesheet' media='print' />

<!-- Section de contenido-->
      <section class="" style="padding: 20px 0px">
        <div class="container-fluid">

            <!-- filtros -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-header">
                            <h3 class="h5"><i class="fa fa-filter" aria-hidden="true"></i> Filtros</h3>

                            <div class="card-close pull-right">
                                <a data-toggle="collapse" href="#card_filtros" aria-expanded="true">
					          		<span class="mi_icon_open">
								         <i class="fa fa-chevron-down"></i>
								    </span>
                                    <span class="mi_icon_close">
								         <i class="fa fa-chevron-up"></i>
								    </span>
                                </a>                                &nbsp;
                                <!-- <a class="remove" href="#">
                                    <i class="fa fa-times"></i>
                                </a> -->
                            </div>
                        </div>
                        <div  class="card-body collapse show" id="card_filtros" >
                            <!-- Filtro Ciclo-->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Ciclo</label>
                                <div class="col-sm-5" >
                                    <?= $select_consultorios ?>
                                </div>
                            </div>



                            <!--<div class="row justify-content-end">
                                <div class="col-md-4">
                                    <button type="button"  id="btn_imprimir" class="btn btn-outline-danger">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Imprimir
                                    </button>
                                </div>
                            </div> -->


                        </div>
                    </div>
                </div>
            </div>


          <div class="row justify-content-center">
          	 <!--empieza contenido lado izquierdo-->
                 <div class="col-md-12" >
  
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Horario</h3>
                    </div>
                    <div class="card-body" id="printScheduleArea">

                        <div class="row justify-content-center">
                            <div class="col-md6">
                                <h4 id="span_titulo_fullCalendar"></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" >
                                <div id="cronograma"></div>
                            </div>

                        </div>

                    </div>
                  </div>       
                </div>
                <!--termina contenido lado izquierdo-->
          </div> <!-- Fin row-->


        </div> <!-- Fin Container -->
      </section>

<!-- MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Título </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="errores_validacion"></div>
                <form id="form_horario">
                    <input type="hidden" id="hidden_fecha_inicio" name="hidden_fecha_inicio" value="" >
                    <input type="hidden" id="hidden_fecha_fin" name="hidden_fecha_fin" value="" >
                    <div class="row">
                        <div class="col-md-4"> <label for="text_hora_inicio" class="form-control-label">Hora Inicio</label> </div>
                        <div class="col-md-4"> <label for="text_hora_fin" class="form-control-label">Hora Fin</label> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="validacion">
                                <input type="text" class="form-control reloj1" id="text_hora_inicio" name="text_hora_inicio" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="validacion">
                                <input type="text" class="form-control reloj2" id="text_hora_fin" name="text_hora_fin" >
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="text_docente" class="form-control-label">Profesional</label>
                        <div>
                            <div id="contenedor_select_profesionales">
                            <br><br></div>
                        </div>

                    </div>
                    <br>
                    <div class="form-group">
                        <label for="text_curso" class="form-control-label">Especidalidad</label>
                        <div>
                            <div id="contenedor_select_especialidad"></div>
                            <input type="hidden" name="hidden_id_especialidad" id="hidden_id_especialidad">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
            </div>
        </div>
    </div>
</div>

<script>
     SELECT_PROFESIONALES  =  <?=  json_encode($select_profesionales) ?> ;
</script>

<!-- 3 =============       FOOTER          ========================= -->
<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						 //Select2 (colegio)
                    					  'librerias/select2/dist/js/select2.js',
                    					  //Sweetalert
                    					   'librerias/sweetalert/sweetalert.min.js',
                    					   //validación
                    					 	'assets/js/jquery.validate.min.js',
                                        //full calendar e idioma español
                                        'librerias/fullcalendar-3.10.0/lib/moment.min.js',
                                        'librerias/fullcalendar-3.10.0/lib/moment-timezone-with-data.js',
                                        'librerias/fullcalendar-3.10.0/fullcalendar.min.js',
                                        'librerias/fullcalendar-3.10.0/locale-all.js',
                                        //PARA EL SPIN (animacion hasta esperar el procesamiento)
                                        'librerias/spin/spin.min.js',
                                        'librerias/spin/spin_variables.js',
                                        //datetimepicker
                                        //'librerias/datetimepicker/moment.min.js',
                                        'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                                        'librerias/datetimepicker/locale/es.js',
                    					  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/horarios/js/registrar.js',
                                           // 'recursos/gestores/horarios/js/mi_impresion.js',
                    					                                                                                  
                                       )
                );  
    
    $this->load->view('template/f_footer', $data);
?>
<?php 
	//para modal de Registro correcto
	$registro_correcto = $this->session->flashdata('registro_correcto');
	if ( isset($registro_correcto) &&  $registro_correcto == true) {?>     
     <script>
         swal( 'Registro Correcto','', "success");         
     </script>    
<?php }?>

           
