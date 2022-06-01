<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Editar unidad',
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
                        'navegacion'    => array ('Gestores'  => '' , 'Unidades' => '' , 'Listar' => base_url('gestores/unidades/listar/listar_unidades') , 'Editar' => '#' ),
                        'titulo'        => 'Editar unidad' ,
                        'titulo_icono'  => 'fa fa-thermometer-quarter',
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
                      <h3 class="h4"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	<br>
                      <form method="POST" action="<?= base_url('gestores/unidades/editar/procesa_editar') ?>">
                        <input type="hidden" name="hidd_id_unidad" value="<?= $unidad->id_unidad ?>" />
                        
                        <div class="form-group row">
  							<label for="txt_nombre"  class="col-sm-4 col-form-label">Nombre</label>
  							  <div class="col-sm-8">
     							<input type="text" class="form-control" id="txt_nombre" name="txt_nombre" placeholder="Ingrese nombre" required="" autocomplete="off" value="<?=  $unidad->nombre_unidad ?>">
    						  </div>
 						</div>

                          <div class="form-group row">
                              <label for="txt_nombre"  class="col-12 col-sm-4 col-form-label">Comentario</label>
                              <div class="col-12 col-sm-8">
                                  <div class="clearfix">
                                      <textarea class="col-sm-12" name="txt_comentario" id="txt_comentario" rows="4"  placeholder="Ingrese Comentario" ><?=  $unidad->comentario_unidad ?></textarea>
                                  </div>
                              </div>
                          </div>
 						

                        
						<br>
                        <div class="form-group text-right">                             
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Editar  y <br> Listar
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
                    					  
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/unidades/js/registrar.js',
                    					                                                                                  
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

           
