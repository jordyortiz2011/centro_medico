<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Registrar Código CIE-10 Descripción',
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
                        'navegacion'    => array ('Gestores'  => '' , 'Códigos CIE-10' => '' ,  'Descripción' => '' , 'Registrar' => '#' ),
                        'titulo'        => 'Registrar Código CIE-10 Descripción' ,
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
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	<br>
                      <form method="POST" id="form_registrar_codigo" action="<?= base_url('gestores/codigos_cie10/registrar/procesa') ?>">

                          <!-- especialidad -->
                          <div class="form-group row">
                              <label for="select_categoria"  class="col-12 col-md-4 col-form-label-lg">Categoria <span class="text-red">*</span> </label>
                              <div class="col-12 col-md-7">
                                  <div class="validacion">
                                      <select class="select2"  name="select_categoria" id="select_categoria" data-width="100%">
                                          <option value="" selected="">Seleccione</option>
                                          <?php foreach ($lst_categorias as $cate) {?>
                                              <option value="<?= $cate -> id_codigo_ciecat ?>" data-codigo="<?= $cate->codigo_ciecat ?>"  <?=  set_select('select_categoria', $cate -> id_codigo_ciecat); ?> ><?= $cate->codigo_ciecat ?>  -  <?= $cate->descripcion_ciecat; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                          </div>



                          <div class="form-group row">
                              <label for="txt_nombre"  class="col-sm-4 col-form-label-lg">Código 4 CARACTERES <span class="text-red">*</span></label>
                              <div class="col-md-1" style="margin-right: 0px;  padding-right: 0px;">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_codigo_tres" name="text_codigo_tres" placeholder="000" maxlength="3" readonly autocomplete="off" value="<?=  set_value('text_codigo'); ?>">
                                  </div>
                              </div>

                              <div class="col-sm-1" style="margin-left: 0px; padding-left: 0px;">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_codigo" name="text_codigo" placeholder="Ingrese campo " maxlength="1" autocomplete="off" value="<?=  set_value('text_codigo'); ?>">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">

                              <label for="txt_nombre"  class="col-sm-4 col-form-label-lg">Descripción <span class="text-red">*</span> </label>
                              <div class="col-sm-8">
                                  <div class="validacion">
                                      <input type="text" class="form-control" id="text_descripcion" name="text_descripcion" placeholder="Ingrese campo"  autocomplete="off" value="<?=  set_value('text_descripcion'); ?>">
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
                    					   
                    					  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/codigos_cie10/js/registrar.js',
                    					                                                                                  
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

           
