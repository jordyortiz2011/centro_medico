<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Registrar consultorio',
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
                        'navegacion'    => array ('Gestores'  => '' , 'Consultorios' => '' , 'Registrar' => '#' ),
                        'titulo'        => 'Registrar consultorio' ,
                        'titulo_icono'  => 'fa fa-th-large',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="" style="padding: 20px 0px">
        <div class="container-fluid">
          <div class="row justify-content-center">
          	
          	 <!--empieza contenido lado izquierdo-->
                 <div class="col-md-8">
  
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	<br>
                      <form method="POST" id="form_registrar_consultorio" action="<?= base_url('gestores/consultorios/registrar/procesa') ?>">
                        <div class="form-group row">
  							<label for="txt_nombre"  class="col-sm-4 col-form-label">Nombre de consultorio<span class="text-red">(*)</span></label>
  							  <div class="col-sm-8">
  							  	<div class="validacion">
  							  		<input type="text" class="form-control " id="text_nombre" name="text_nombre" placeholder="Ingrese campo" required="" maxlength="100" autocomplete="off" value="<?=  set_value('text_nombre'); ?>">
  							  	</div>     							
    						  </div>
 						</div>

                          <div class="form-group row">
                              <label for="txt_nombre"  class="col-sm-4 col-form-label">Hora inicio atención <span class="text-red">(*)</span> <br><b>(HH:MM)</b> </label>
                              <div class="col-sm-3">
                                  <div class="validacion">
                                      <input type="text" class="form-control reloj " id="text_hora_inicio" name="text_hora_inicio" placeholder="HH:MM" required="" maxlength="100" autocomplete="off" value="<?=  set_value('text_hora_inicio'); ?>">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="txt_nombre"  class="col-sm-4 col-form-label">Hora fin atención  <span class="text-red">(*)</span> <br><b>(HH:MM)</b></label>
                              <div class="col-sm-3">
                                  <div class="validacion">
                                      <input type="text" class="form-control reloj" id="text_hora_fin" name="text_hora_fin" placeholder="HH:MM" required="" maxlength="100" autocomplete="off" value="<?=  set_value('text_hora_fin'); ?>">
                                  </div>
                              </div>
                          </div>


                        
						<br>
                        <div class="form-group text-right">       
                          <button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button>
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                          </button>                     
                        </div>
                          <hr>
                          <p> <span class="text-red">(*)</span> Campos obligatorios</p>
                        
                      </form>
                    </div>
                  </div>       
                </div>
                <!--termina contenido lado izquierdo-->
                   
         	
         	
         	
          </div>
        </div>
      </section>

<!-- 3 =============       FOOTER          ========================= -->
<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						 //Select2 (colegio)
                    					  'librerias/select2/dist/js/select2.js',
                                        //Numeric
                                        'librerias/numeric/jquery.numeric.min.js',
                    					  //Sweetalert
                    					   'librerias/sweetalert/sweetalert.min.js',
                    					   //validación
                    					 	'assets/js/jquery.validate.min.js',
                                            //datetimepicker
                                            'librerias/datetimepicker/moment.min.js',
                                            'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                                            'librerias/datetimepicker/locale/es.js',
                    					   
                    					  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/consultorios/js/registrar.js',
                    					                                                                                  
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
<?php } ?>

           
