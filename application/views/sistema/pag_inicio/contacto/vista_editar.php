<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Contacto',
                    'css'           => array (
                    						   
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                    					   		 //validación
                    					 		'assets/css/jquery.validate.css',                     
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Sistema'  => '' , 'Página Inicio' => '' , 'Contacto' => '#' ),
                        'titulo'        => 'Contacto' ,
                        'titulo_icono'  => 'fa fa-user-circle',
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
                      <h3 class="h4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Contacto</h3>
                    </div>
                    <div class="card-body">
                    	<!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?> 
                	
                      <form id="form_contacto" method="POST" action="<?= base_url('sistema/pag_inicio/contacto/editar/procesa_editar') ?>" method="POST" >
                        <input type="hidden" name="hidd_id_contac" value="<?=  $contacto->id_contac ?>" />
                       <!-- <h4 class="h3">Datos </h4> <hr> -->
                        <div class="row">
                        	<!-- col Izquierda -->
                        	<div class="col-12 col-md-10">
	                        	<!-- Teléfono-->
	                        	<div class="form-group row">
		  							<label for="txt_telefono"  class="col-12 col-md-4 col-form-label-lg">Teléfono <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"   name="txt_telefono"  id="txt_telefono" placeholder="Ingrese Teléfono" 
		  							  		 maxlength="6" autocomplete="off" value="<?=  $contacto->telefono_contac?>">
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 						<!-- Dirección-->	                        	
	                        		<div class="form-group row">
			  							<label for="txt_direccion"  class="col-12 col-md-4 col-form-label-lg">Dirección <span class="text-danger">*</span></label>
			  							  <div class="col-12 col-md-7">
			  							  	<div class="validacion">
			  							  		<input type="text" class="form-control form-control-lg"  id="txt_direccion" name="txt_direccion" placeholder="Ingrese Dirección" required=""
			  							  		  autocomplete="off" value="<?=  $contacto->direccion_contac ?>">
			  							  		
			  							  	</div>     							
			    						  </div>
			 						</div>	
			 					<!-- Apellido PAt-->
		 						<div class="form-group row">
		  							<label for="txt_correo"  class="col-12 col-md-4 col-form-label-lg">Correo <span class="text-danger">*</span></label>
		  							  <div class="col-12 col-md-7">
		  							  	<div class="validacion">
		  							  		<input type="text" class="form-control form-control-lg"  id="txt_correo" name="txt_correo" placeholder="Ingrese correo" required="" 
		  							  		 autocomplete="off" value="<?=  $contacto->correo_contac ?>">
		  							  	</div>     							
		    						  </div>
		 						</div>	
		 					 						
                        	</div><!-- fin col izquierda -->
                        	
                      
                        </div> <!-- fin fila -->
                        
                        <br>
                        
                      					
 						<p> 
 							 <span class="text-danger align-baseline " style="font-size: 1.4em;">* </span>  (Datos Obligatorios)
 						</p>
 						
 					
 					
                      
                        
						<br>
                        <div class="form-group text-right">       
                          <!--<button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                          </button> -->
                          <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="editar">
                          	<i class="fa fa-floppy-o" aria-hidden="true"></i> Editar  <br> 
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
                						 
                    					  //Sweetalert
                    					   'librerias/sweetalert/sweetalert.min.js',
                    					  
                    					   	//numeric
                    					  	'librerias/numeric/jquery.numeric.min.js',   
                    					   //validación
                    					 	'assets/js/jquery.validate.min.js', 	
                    					 	
										
                    					   //librería general
                    					  'recursos/sistema/pag_inicio/contacto/js/editar.js', 
                    					                                                                                  
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

           
