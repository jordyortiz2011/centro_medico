<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Importar pacientes',
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
                        'navegacion'    => array ('Gestores'  => '' , 'Pacientes' => '' , 'Importar' => '#' ),
                        'titulo'        => 'Importar pacientes' ,
                        'titulo_icono'  => 'fa fa-file-excel-o',
                        'descripcion'   => 'Este módulo permite importar pacientes de un formato Excel'
                        
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
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Importar</h3>
                    </div>
                    <div class="card-body">
                        <!-- Validación personal -->
                        <?php
                            if ( $this->input->get('col') ){
                                $get = $this->input->get();

                                echo '<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">';
                                echo  " Error de dato en COLUMNA: <b>"  . $get['col'] . "</b> - FILA <b>". $get['fila'] ."</b>" ;
                                if($get['col'] == 'M') {
                                    echo "<br>EESS no registrado en la BD";
                                }
                                echo '</buttom></div>';
                                echo '<br>';
                            }

                        ?>

                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 



                      <form id="form_registrar_paciente" method="POST" action="<?= base_url('gestores/pacientes/importar/procesa') ?>"  enctype="multipart/form-data" >

                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-7">


                                <!-- DOC -->
                                <div class="form-group row">
                                    <label for="txt_apellido_mat"  class="col-12 col-md-4 col-form-label-lg">Adjuntar archivo </label>
                                    <div class="col-12 col-md-7">
                                        <div class="validacion">
                                            <!-- <input type="text" class="form-control form-control-lg"  id="text_num_documento" name="text_num_documento" placeholder="Ingrese campo" maxlength="8"  autocomplete="off" value=""> -->
                                            <input type="file" name="file_archivo" id="file_archivo" accept=""  > <!-- accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"-- >
                                        </div>
                                    </div>
                                </div>




                        	</div><!-- fin col izquierda -->
                        	
                        	<!-- col derecha -->
                        	<div class="col-12 col-md-5">
                        		<!-- sexo -->




                        	</div><!-- fin col derecha -->
                        </div> <!-- fin fila -->

                          <br>


                      
                        
						<br>
                        <div class="form-group text-right">       
                          <!--<button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button> -->
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


           
