<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Editar paciente',
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
                        'navegacion'    => array ('Gestores'  => '' , 'Pacientes' => '' , 'Editar' => '#' ),
                        'titulo'        => 'Editar paciente' ,
                        'titulo_icono'  => 'fa fa-address-card-o',
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
                	
                      <form id="form_registrar_paciente" method="POST" action="<?= base_url('gestores/pacientes/editar/procesa_editar') ?>"  enctype="multipart/form-data" >
                        <input type="hidden" name="hidden_id_paciente" value="<?= $paciente->id_paciente ?>">
                          <h4 class="h3">Datos Personales</h4> <hr>
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-7">

		 						<!-- Tipo de Documento-->
	                        		<div class="form-group row">
			  							<label for="txt_nombres"  class="col-12 col-md-4 col-form-label-lg">Tipo DOC. <span class="text-danger">*</span></label>
			  							  <div class="col-12 col-md-7">
			  							  	<div class="validacion">
                                               <?= $select_tipo_doc ?>
			  							  	</div>     							
			    						  </div>
			 						</div>

                                <!-- DOC -->
                                <div class="form-group row">
                                    <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Nº de Documento </label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_num_documento" name="text_num_documento" placeholder="Ingrese campo" maxlength="8"  autocomplete="off" value="<?=  $paciente->excel_dni_paci ?>">
                                        </div>
                                    </div>
                                </div>

			 					<!-- Asegurado -->
		 						<div class="form-group row">
		  							<label for="txt_apellido_pat"  class="col-12 col-md-4 col-form-label-lg">Apellidos y nombres <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="text_nombres" name="text_nombres" placeholder="Ingrese campo" required="" autocomplete="off" value="<?=  $paciente->excel_asegurado_paci ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>

                                <!-- Establecimiento -->
                                <div class="form-group row">
                                    <label for="txt_dni"  class="col-12 col-md-4 col-form-label-lg">Establecimiento de salud:   <span class="text-red">*</span> </label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <?= $select_eess ?>
                                        </div>
                                    </div>
                                </div>


                        	</div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-5">
                        		<!-- sexo -->
                        		<div class="form-group row">
		  							<label for="radio_sexo"  class="col-12 col-md-3 col-form-label-lg">Sexo <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<?= $radio_sexo ?>
		  							  	</div>     							
		    						  </div>
		 						</div>

                                <!-- Fecha NAci-->
                                <div class="form-group row">
                                    <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_fecha_naci" name="text_fecha_naci" placeholder="Seleccione "  autocomplete="off" value="<?=  $fecha_naci_string ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Código historial -->
                                <div class="form-group row">
                                    <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Cod. Historial </label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <input type="text" class="form-control form-control-lg"  id="text_historial" name="text_historial" placeholder="Ingrese campo "  autocomplete="off" value="<?=  $paciente->codHistorial_paci ?>">
                                        </div>
                                    </div>
                                </div>

                        	</div><!-- fin col derecha -->
                        </div> <!-- fin fila -->

                          <br>
                          <div class="form-group row">
                              <label for="txt_direccion"  class="col-12 col-md-3 col-form-label-lg">¿Posee SIS? </label>
                              <div class="col-12 col-md-7">
                                  <div class="validacion">
                                      <input type="checkbox" name="checkbox_posee_sis" id="checkbox_posee_sis"
                                           <?php echo $paciente->posee_sis_paci == 1 ? 'checked' : ' ' ?>
                                             data-toggle="toggle"   data-on="SI" data-off="NO"
                                             data-onstyle="primary"  data-offstyle="danger">
                                  </div>
                              </div>
                          </div>

                          <div id="contenedor_datos_sis" class="<?php echo $paciente->posee_sis_paci == 1 ? '' : 'd-none' ?>">
                              <h4 class="h3">Datos SIS</h4> <hr>
                              <div class="row">
                                  <!-- col Izquierda -->
                                  <div class="col-12 col-md-7">
                                      <!-- ID SIS-->
                                      <div class="form-group row">
                                          <label for="txt_dni"  class="col-12 col-md-4 col-form-label-lg">ID SIS <span class="text-red">*</span> </label>
                                          <div class="col-12 col-md-7">
                                              <div class="validacion">
                                                  <input type="text" class="form-control form-control-lg"   name="text_id_sis"  id="text_id_sis" placeholder="Ingrese campo" maxlength="20" autocomplete="off"  value="<?=  $paciente->excel_idSis_paci  ?>">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Nro Formato -->
                                      <div class="form-group row">
                                          <label for="txt_dni"  class="col-12 col-md-4 col-form-label-lg">Nro Formato </label>
                                          <div class="col-12 col-md-7">
                                              <div class="validacion">
                                                  <input type="text" class="form-control form-control-lg"   name="text_numformato"  id="text_numformato" placeholder="Ingrese campo" maxlength="50" autocomplete="off" value="<?=  $paciente->excel_nroFormato_paci  ?>">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- ESTADO -->
                                      <div class="form-group row">
                                          <label for="txt_nombres"  class="col-12 col-md-4 col-form-label-lg">Estado </label>
                                          <div class="col-12 col-md-7">
                                              <div class="validacion">
                                                <?= $select_estado ?>
                                              </div>
                                          </div>
                                      </div>



                                  </div><!-- fin col izquierda -->

                                  <!-- col derecha -->
                                  <div class="col-12 col-md-5">

                                      <!-- Fecha Afiliación -->
                                      <div class="form-group row">
                                          <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Fecha Afiliación </label>
                                          <div class="col-12 col-md-7">
                                              <div class="validacion">
                                                  <input type="text" class="form-control form-control-lg"  id="text_fecha_afiliacion" name="text_fecha_afiliacion" placeholder="Ingrese campo"  autocomplete="off" value="<?=  $fecha_afiliacion_string ?>">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Fecha Baja -->
                                      <div class="form-group row">
                                          <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Fecha baja </label>
                                          <div class="col-12 col-md-7">
                                              <div class="validacion">
                                                  <input type="text" class="form-control form-control-lg"  id="text_fecha_baja" name="text_fecha_baja" placeholder="Ingrese campo" autocomplete="off" value="<?=  $fecha_baja_string ?>">
                                              </div>
                                          </div>
                                      </div>


                                  </div><!-- fin col derecha -->
                              </div> <!-- fin fila -->
                          </div>

                      
                        
						<br>
                        <div class="form-group text-right">       
                          <!--<button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button>  -->
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Editar y <br> Listar
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
                    					  'recursos/gestores/pacientes/js/registrar.js',
                    					                                                                                  
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


           
