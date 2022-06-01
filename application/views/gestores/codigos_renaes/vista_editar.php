<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Editar Código RENAES',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Gestores'  => '' , 'Código RENAES' => '' , 'Editar' => '#' ),
                        'titulo'        => 'Editar código RENAES' ,
                        'titulo_icono'  => 'fa fa-barcode',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="">
        <div class="container-fluid">
          <div class="row justify-content-center">
          	
          	 <!--empieza contenido lado izquierdo-->
                 <div class="col-md-8">
  
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	<br>
                      <form method="POST" id="form_registrar_renae" action="<?= base_url('gestores/codigos_renaes/editar/procesa_editar') ?>">
                        <input type="hidden" name="hidd_id_codigo" value="<?= $codigo->id_codigo_renaes ?>" />

                          <div class="form-group row">

  							<label for="txt_nombre"  class="col-sm-4 col-form-label">Código RENAES <span class="text-red">(*)</span></label>
  							  <div class="col-sm-3">
  							  	<div class="validacion">
  							  		<input type="text" class="form-control numeric" id="text_cod_renaes" name="text_cod_renaes" placeholder="Ingrese campo" required="" maxlength="4" autocomplete="off" value="<?=  $codigo->cod_renaes_codren ?>">
  							  	</div>     							
    						  </div>
 						</div>

                          <div class="form-group row">

                              <label for="txt_nombre"  class="col-sm-4 col-form-label">Micro Red Putumayo <span class="text-red">(*)</span> </label>
                              <div class="col-sm-8">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_micro" name="text_micro" placeholder="Ingrese campo " required="" autocomplete="off" value="<?=  $codigo->micro_red_codren ?>">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">

                              <label for="txt_nombre"  class="col-sm-4 col-form-label">Distrito a la que pertenece</label>
                              <div class="col-sm-8">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_distrito" name="text_distrito" placeholder="Ingrese campo"  autocomplete="off" value="<?=  $codigo->distrito_codren ?>">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">

                              <label for="txt_nombre"  class="col-sm-4 col-form-label">Código EESS (del archivo excel)</label>
                              <div class="col-sm-8">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_codexcel" name="text_codexcel" placeholder="Ingrese campo"  autocomplete="off" value="<?=  $codigo->codexcel_codren ?>">
                                  </div>
                              </div>
                          </div>



                        
						<br>
                        <div class="form-group text-right">       

                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Editar y <br> Listar
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
                    					   
                    					  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/codigos_renaes/js/registrar.js',
                    					                                                                                  
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

           
