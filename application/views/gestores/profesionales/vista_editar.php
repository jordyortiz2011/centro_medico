<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Editar profesional',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                    					   		//datetimepicker
                    					   		'librerias/datetimepicker/bootstrap-datetimepicker.min.css',
                    					   		'librerias/datetimepicker/color_dias_bloqueado.css',
                    					   		
                    					   		 //validación
                    					 		'assets/css/jquery.validate.css', 
                    					 		
												// Bootstrap File Input ( foto)
											   'librerias/kartik/css/fileinput2.css' ,
                                      		    'recursos/gestores/empleados/css/subir_foto.css',
                                      		    
												//Toggle(checkox - radiobuttom)
                    					   		'librerias/bootstrap-toggle/bootstrap-toggle.min.css',
                    					   		
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Gestores'  => '' , 'Profesional' => '' , 'Editar' => '#' ),
                        'titulo'        => 'Editar  profesional' ,
                        'titulo_icono'  => 'fa fa-user-md',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="" style="padding: 20px 0px">
        <div class="container-fluid">
          <div class="row justify-content-center">
          	
          	 <!--empieza contenido lado izquierdo-->
                 <div class="col-md-11">
  
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?>

                      <form id="form_registrar_profesional" method="POST" action="<?= base_url('gestores/profesionales/editar/procesa_editar') ?>"  enctype="multipart/form-data" >
                          <input type="hidden" name="hidden_id_profesional" value="<?= $profesional->user_id ?> " />

                          <h4 class="h3">Datos Personales</h4> <hr>
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-7">

			 					<!-- Apellido paterno -->
		 						<div class="form-group row">
		  							<label for="txt_apellido_pat"  class="col-12 col-md-4 col-form-label-lg">Apellido Paterno <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="text_apellido_pat" name="text_apellido_pat" placeholder="Ingrese campo" required="" autocomplete="off" value="<?=  $profesional->apellido_pat_user ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>

                                <!-- Apellido materno -->
                                <div class="form-group row">
                                    <label for="txt_apellido_pat"  class="col-12 col-md-4 col-form-label-lg">Apellido Materno <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_apellido_mat" name="text_apellido_mat" placeholder="Ingrese campo" required="" autocomplete="off" value="<?=  $profesional->apellido_mat_user ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Nombres -->
                                <div class="form-group row">
                                    <label for="txt_apellido_pat"  class="col-12 col-md-4 col-form-label-lg">Nombres <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_nombres" name="text_nombres" placeholder="Ingrese campo" required="" autocomplete="off" value="<?=  $profesional->nombres_user ?>">
                                        </div>
                                    </div>
                                </div>


                            </div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-5">

                                <!-- DOC -->
                                <div class="form-group row">
                                    <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">DNI <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_dni" name="text_dni" placeholder="Ingrese campo" maxlength="8"  autocomplete="off" value="<?=  $profesional->dni_user ?>">
                                        </div>
                                    </div>
                                </div>

                        	</div><!-- fin col derecha -->
                        </div> <!-- fin fila -->

                          <br>
                        <h4 class="h3">Datos de la Cuenta</h4> <hr>
                        <div class="row">
                              <!-- col Izquierda -->
                              <div class="col-12 col-md-7">
                                  <!-- especialidad -->
                                  <div class="form-group row">
                                      <label for="txt_dni"  class="col-12 col-md-4 col-form-label-lg">Especialidad <span class="text-red">*</span> </label>
                                      <div class="col-12 col-md-7">
                                          <div class="validacion">
                                             <?= $select_especialidad ?>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Usuario-->
                                  <div class="form-group row">
                                      <label for="txt_telefono"  class="col-12 col-md-4 col-form-label-lg"> Usuario <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-7">
                                          <div class="validacion">
                                              <input type="text" class="form-control form-control-lg"  id="text_username" name="text_username"  maxlength="15" autocomplete="off"  value="<?=  $profesional->username ?>">

                                          </div>
                                      </div>
                                  </div>
                                  <!-- Contraseña -->
                                  <div class="form-group row">
                                      <label for="txt_celular"  class="col-12 col-md-4 col-form-label-lg">Contraseña <span class="text-danger">*</span> </label>
                                      <div class="col-12 col-md-7">
                                          <div class="validacion">
                                              <input type="password" class="form-control form-control-lg"  id="text_clave" name="text_clave"  autocomplete="off" >
                                          </div>
                                      </div>
                                  </div>



                              </div><!-- fin col izquierda -->

                              <!-- col derecha -->
                              <div class="col-12 col-md-5">

                                  <!-- Email-->
                                  <div class="form-group row">
                                      <label for="txt_correo"  class="col-12 col-md-3 col-form-label-lg ">Correo <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-7">
                                          <div class="validacion">
                                              <input type="text" class="form-control form-control-lg"  id="text_correo" name="text_correo" placeholder="Ingrese Correo" required="" autocomplete="off" value="<?=  $profesional->email ?>">
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Activo -->
                                  <div class="form-group row">
                                      <label for="txt_direccion"  class="col-12 col-md-3 col-form-label-lg">Activo </label>
                                      <div class="col-12 col-md-7">
                                          <div class="validacion">
                                              <input type="checkbox" name="checkbox_estado" <?= $profesional->banned == 0 ? 'checked' : ' ' ?> checked data-toggle="toggle"   data-on="SI" data-off="NO"
                                                     data-onstyle="primary"  data-offstyle="danger">
                                          </div>
                                      </div>
                                  </div>


                              </div><!-- fin col derecha -->
                          </div> <!-- fin fila -->
                      
                        
						<br>
                        <div class="form-group text-right">       
                          <!--<button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button>-->
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                          </button>                     
                        </div>


                          <br>
                          <p>
                              <span class="text-danger align-baseline " style="font-size: 1.4em;">* </span>  (Datos Obligatorios)
                          </p>
                        
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
                    					  //Sweetalert
                    					   'librerias/sweetalert/sweetalert.min.js',
                    					   //datetimepicker
                    					   'librerias/datetimepicker/moment.min.js',
                    					   'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                    					   'librerias/datetimepicker/locale/es.js',   
                    					   //JQUERY UI (spinner)
                    					   	'librerias/jquery-ui-1.12.1.full/jquery-ui.min.js',   
                    					   	//numeric
                    					  'librerias/numeric/jquery.numeric.min.js',   
                    					   //validación
                    					 	'assets/js/jquery.validate.min.js', 	
                    					 	

	                                        
	                                        
											 //Toggle(checkox - radiobuttom)
                    					    'librerias/bootstrap-toggle/bootstrap-toggle.min.js',			  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/profesionales/js/editar.js',
                    					                                                                                  
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


           
