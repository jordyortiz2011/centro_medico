<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Agregar Portada',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                    					   		//JQUERY UI (spinner)
                    					   		'librerias/jquery-ui-1.12.1.full/jquery-ui.theme.min.css',
                    					   		
                    					   		 //validación
                    					 		'assets/css/jquery.validate.css', 
                    					 		
												// Bootstrap File Input ( foto)
											   'librerias/kartik/css/fileinput2.css' ,
                                      		    'recursos/sistema/pag_inicio/portada/css/subir_foto.css',
                                      		    
												//colorPicker
                    					   		'librerias/colorpicker-2.5.2/dist/css/bootstrap-colorpicker.min.css',
                                      		    
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
                        'navegacion'    => array ('Sistema'  => '' , 'Pagina Inicio' => '', 'Portada' => '' ,  'Listar' => '' ,  'Agregar' => '#' ),
                        'titulo'        => 'Agregar Portada' ,
                        'titulo_icono'  => 'fa fa-home',
                        'descripcion'   => '<i>Agregar una nueva imagen o texto para mostrar en la Página de Inicio</i>' 
                        
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
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	
                      <form id="form_agregar_portada" method="POST" action="<?= base_url('sistema/pag_inicio/portada/agregar/procesa') ?>" method="POST" enctype="multipart/form-data" >
                        <h4 class="h3">Datos </h4> <hr>
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-6">
	                        	<!-- Tipo empleado -->
	                        	<div class="form-group row">
		  							<label for="txt_dni"  class="col-12 col-md-4  col-form-label-lg ">Tipo  <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<select class="select2 form-control form-control-lg"  name="select_tipo_portada" id="select_tipo_portada" data-placeholder="Seleccione" >
												<option></option>
												<option value="1"  <?= set_select('select_tipo_portada', '1') ?>>Imagen</option>
												<option value="2" <?= set_select('select_tipo_portada', '2') ?>>Texto</option>
											</select>													
												
		  							  	</div>     							
		    						  </div>
		 						</div>		
		 						<!-- Título-->	                        	
	                        		<div class="form-group row">
			  							<label for="txt_nombres"  class="col-12 col-md-4 col-form-label-lg">Título <span class="text-danger d-none conten_danger ">*</span> </label>
			  							  <div class="col-12 col-md-7">
			  							  	<div class="validacion">
			  							  		<input type="text" class="form-control form-control-lg"  id="txt_titulo" name="txt_titulo" placeholder="Ingrese Título"  autocomplete="off" value="<?=  set_value('txt_titulo'); ?>">
			  							  		
			  							  	</div>     							
			    						  </div>
			 						</div>	
			 					
			 					<!-- Descripción -->
                        		<div class="form-group row">
		  							<label for="txt_direccion"  class="col-12 col-md-4 col-form-label-lg">Descripción</label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<textarea class="form-control form-control-lg"  id="txt_descripcion" name="txt_descripcion"   autocomplete="off" ><?= set_value('txt_descripcion') ?></textarea>
		  							  	</div>     							
		    						  </div>
		 						</div>
		 						
		 						<div class="form-group row">
		  							<label for="txt_jornada"  class="col-12 col-md-4 col-form-label-lg">Prioridad <span class="text-danger">*</span>
		  								<button type="button" class="btn btn-info btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="El número de orden en el que será mostrado en la Página de Inicio">
				  							<i  class="fa fa-question-circle-o">				  								
				  							</i>
				  						</button>
		  							</label>
		  							  <div class="col-12 col-md-5">
		     							<input type="text" class="form-control form-control-lg text-center"  id="txt_prioridad" name="txt_prioridad"
		     							 placeholder="Ingrese "  autocomplete="off" style="display: inline-block; width: 70%; margin-right: 0.5em;" value="<?=  set_value('txt_prioridad'); ?>">
		    						  </div>
		 						</div>
		 						
		 							 						
                        	</div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-6">
                        		
		 						<!-- Foto -->
                        		<div class="form-group row d-none" id="conten_imagen">
		  							<label for="foto_portada"  class="col-12 col-md-3 col-form-label-lg">Foto</label>
		  							  <div class="col-12 col-md-7 text-center ">
		  							  	  <div class="kv-avatar">
								                <div class="file-loading" align="center">								                	
								                		<input id="foto_portada" name="foto_portada" type="file" >
								                </div>
								            </div><br>  
								            <i> <span class="text-blue"> + </span> 2 MB máximo permitido</i>
								            <i> <span class="text-blue"> + </span> 2048 x 1500 dimensión máxima</i>							
		    						  </div>
		 						</div>
		 						
		 						<div class="form-group row conten_color d-none">
		  							<label for="txt_nombre"  class="col-12 col-sm-3 col-form-label-lg">Color de Texto</label>
		  							  <div class="col-12 col-md-5">
		  							  	<div class="clearfix input-group colorpicker-component" id="div_color_texto">
		  							  		<input type="text" class="form-control" id="txt_color_texto" name="txt_color_texto" readonly=""  placeholder="Seleccione color" required="" autocomplete="off" value="<?=  set_value('txt_color_texto'); ?>">
		  							  		<span class="input-group-addon"><i></i></span>
		  							  	</div>     							
		    						  </div>
		 						</div>
		 						<br>
		 						<div class="form-group row conten_color d-none">
		  							<label for="txt_nombre"  class="col-12 col-sm-3 col-form-label-lg">Color de Fondo</label>
		  							  <div class="col-12 col-md-5">
		  							  	<div class="clearfix input-group colorpicker-component" id="div_color_fondo">
		  							  		<input type="text" class="form-control" id="txt_color_fondo" name="txt_color_fondo" readonly=""  placeholder="Seleccione color" required="" autocomplete="off" value="<?=  set_value('txt_color_fondo'); ?>">
		  							  		<span class="input-group-addon"><i></i></span>
		  							  	</div>     							
		    						  </div>
		 						</div>
		 						
		 						
		 						
		 						<!-- Estado -->
                        		<div class="form-group row">
		  							<label for="txt_direccion"  class="col-12 col-md-3 col-form-label-lg">Activo 
			  							<button type="button" class="btn btn-info btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="Mostrar portada en la Página de inicio">
				  							<i  class="fa fa-question-circle-o">				  								
				  							</i>
				  						</button>
		  							</label>
		  							  <div class="col-12 col-md-7">
		  							  	<br>
		  							  	<div class="validacion">
		  							  		 <input type="checkbox" name="checkbox_estado" checked data-toggle="toggle"   data-on="SI" data-off="NO"
    						    			 data-onstyle="primary"  data-offstyle="danger">
		  							  	</div>     							
		    						  </div>
		 						</div>
		 						
		 						
                        	</div><!-- fin col derecha -->
                        </div> <!-- fin fila -->
                        
                        <br>                        
                      
 						<p> 
 							 <span class="text-danger align-baseline " style="font-size: 1.4em;">* </span> <i> (Datos Obligatorios)</i>
 						</p>
 						
 					
 					
                      
                        
						<br>
                        <div class="form-group text-right">       
                          <button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button> 
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
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
                						 //Select2 
                    					  'librerias/select2/dist/js/select2.js',
                    					  //Sweetalert
                    					   'librerias/sweetalert/sweetalert.min.js',                    					  
                    					   //JQUERY UI (spinner)
                    					   	'librerias/jquery-ui-1.12.1.full/jquery-ui.min.js',   
                    					   	//numeric
                    					  	'librerias/numeric/jquery.numeric.min.js',   
                    					   //validación
                    					 	'assets/js/jquery.validate.min.js', 	
                    					 	
											 //para editar foto                                     
	                                        'librerias/kartik/js/fileinput.min.js' , 
	                                        'librerias/kartik/js/locales/es.js'	,                              
	                                        'recursos/sistema/pag_inicio/portada/js/subir_foto.js'  ,	                                        
	                                        
											 //Toggle(checkox - radiobuttom)
                    					    'librerias/bootstrap-toggle/bootstrap-toggle.min.js',			  
                    					  	
											 //ocultar campo imagen, de acuerdo al select
                    					     'recursos/sistema/pag_inicio/portada/js/select_tipo.js',
                    					     
											 //colorPicker
                    					     'librerias/colorpicker-2.5.2/dist/js/bootstrap-colorpicker.min.js', 
										  
                    					  	//librería general
                    					    'recursos/sistema/pag_inicio/portada/js/agregar.js', 
                    					                                                                                  
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
<?php } else if ($estado_registro == 'registrar_error' && isset($estado_registro) ){ ?>
	<script>
         swal( 'Error al registrar','', "error");         
     </script> 
<?php } ?>

           
