<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Editar Usuario',
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
                                      		    'recursos/sistema/usuarios/css/subir_foto.css',
                                      		    
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
                        'navegacion'    => array ('Sistema'  => '' , 'Usuarios' => '' , 'Editar' => '#' ),
                        'titulo'        => 'Editar usuario' ,
                        'titulo_icono'  => 'fa fa-users',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="">
        <div class="container-fluid">
          <div class="row justify-content-center">
          	
          	 <!--empieza contenido lado izquierdo-->
                 <div class="col-md-11">
  
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	
                      <form id="form_agregar_usuario" method="POST" action="<?= base_url('sistema/usuarios/editar/procesa') ?>" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="hidd_id_usuario" value="<?= $usuario->user_id ?>" />
                        <h4 class="h3">Datos Personales</h4> <hr>
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-6">
	                        	<!-- dni-->
	                        	<div class="form-group row">
		  							<label for="txt_dni"  class="col-12 col-md-4 col-form-label-lg">DNI <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"   name="txt_dni"  id="txt_dni" placeholder="Ingrese DNI" maxlength="8" autocomplete="off" value="<?=  $usuario->dni_user ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 						<!-- Nombres-->	                        	
	                        		<div class="form-group row">
			  							<label for="txt_nombres"  class="col-12 col-md-4 col-form-label-lg">Nombres <span class="text-danger">*</span></label>
			  							  <div class="col-12 col-md-7">
			  							  	<div class="validacion">
			  							  		<input type="text" class="form-control form-control-lg"  id="txt_nombres" name="txt_nombres" placeholder="Ingrese Nombres" required="" autocomplete="off" value="<?=  $usuario->nombres_user  ?>">
			  							  		
			  							  	</div>     							
			    						  </div>
			 						</div>	
			 					<!-- Apellido PAt-->
		 						<div class="form-group row">
		  							<label for="txt_apellido_pat"  class="col-12 col-md-4 col-form-label-lg">Apell. Pat. <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="txt_apellido_pat" name="txt_apellido_pat" placeholder="Ingrese Apellido Paterno" required="" autocomplete="off" value="<?=  $usuario->apellido_pat_user  ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 						<!-- Apellido Mat-->
		 						<div class="form-group row">
		  							<label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Apell. Mat. <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="txt_apellido_mat" name="txt_apellido_mat" placeholder="Ingrese Apellido Materno" required="" autocomplete="off" value="<?=  $usuario->apellido_mat_user  ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>
		 						
		 							 						
                        	</div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-6">
                        	
		 						<!-- Foto -->
                        		<div class="form-group row">
		  							<label for="foto_empleado"  class="col-12 col-md-3 col-form-label-lg">Foto</label>
		  							  <div class="col-12 col-md-7 text-center">
		  							  	  <div class="kv-avatar">
								                <div class="file-loading" align="center">
								                    <input id="foto_usuario" name="foto_usuario" type="file" >
								                </div>
								            </div><br>  
								            <i> <span class="text-blue"> + </span> 2 MB máximo permitido</i>
								            <i> <span class="text-blue"> + </span> 1024 x 768 dimensión máxima</i>							
		    						  </div>
		 						</div>
                        	</div><!-- fin col derecha -->
                        </div> <!-- fin fila -->
                        
                        <br>
                        
                         <h4 class="h3">Datos de la Cuenta</h4> <hr>
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-6">
                        		
                        		<!-- Tipo Usuario -->
	                        	<div class="form-group row">
		  							<label for="select_tipo"  class="col-12 col-md-4 col-form-label-lg ">Tipo <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<?= $select_tipo_usuario ?>
		  							  	</div>     							
		    						  </div>
		 						</div>

                                <!-- Departamento al que pertenece el Tecnico -->
                                <div class="form-group row" id="contenedor_agencia">
                                    <label for="select_agencia"  class="col-12 col-md-4 col-form-label-lg ">Agencia. <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <?= $select_agencias ?>
                                        </div>
                                    </div>
                                </div>
	                        	
		 						<!-- Usuario-->	                        	
	                        		<div class="form-group row">
			  							<label for="txt_telefono"  class="col-12 col-md-4 col-form-label-lg"> Usuario <span class="text-danger">*</span></label>
			  							  <div class="col-12 col-md-7">
			  							  	<div class="validacion">
			  							  		<input type="text" class="form-control form-control-lg"  id="txt_username" name="txt_username"  maxlength="15" autocomplete="off"  value="<?=  $usuario->username ?>">
			  							  		
			  							  	</div>     							
			    						  </div>
			 						</div>	
			 					<!-- Contraseña -->
		 						<div class="form-group row">
		  							<label for="txt_celular"  class="col-12 col-md-4 col-form-label-lg">Contraseña <span class="text-danger">*</span> </label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="password" class="form-control form-control-lg"  id="txt_clave" name="txt_clave"  autocomplete="off" >
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 							
                        	</div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-6">
                        		<!-- Email-->
	                        	<div class="form-group row">
		  							<label for="txt_correo"  class="col-12 col-md-3 col-form-label-lg ">Correo <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-8">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="txt_correo" name="txt_correo" placeholder="Ingrese Correo" required="" autocomplete="off" value="<?=  $usuario->email ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 						
		 						<!-- Activo -->
                        		<div class="form-group row">
		  							<label for="txt_direccion"  class="col-12 col-md-3 col-form-label-lg">Activo </label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		 <input type="checkbox" name="checkbox_estado" <?php echo $usuario->banned == 0 ? 'checked' : ' ' ?> data-toggle="toggle"   data-on="SI" data-off="NO"
    						    			 data-onstyle="primary"  data-offstyle="danger">
		  							  	</div>     							
		    						  </div>
		 						</div>
                        		
                        	</div><!-- fin col derecha -->
                        </div> <!-- fin de fila -->					
                   
 						<br>
 						<p> 
 							 <span class="text-danger align-baseline " style="font-size: 1.4em;">* </span>  (Datos Obligatorios)
 						</p>
 						
 					
 					
                      
                        
						<br>
                        <div class="form-group text-right">       
                          <!--<button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button> -->
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Editar y <br> Listar
                          </button>                     
                        </div>
                        
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
                    					 	
											 //para editar foto                                     
	                                        'librerias/kartik/js/fileinput.min.js' , 
	                                        'librerias/kartik/js/locales/es.js'	,                              
	                                        'recursos/sistema/usuarios/js/subir_foto.js'  ,
	                                        
	                                        
											 //Toggle(checkox - radiobuttom)
                    					    'librerias/bootstrap-toggle/bootstrap-toggle.min.js',			  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/sistema/usuarios/js/editar.js',
                                          'recursos/sistema/usuarios/js/select_agencias.js',
                    					                                                                                  
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


           
