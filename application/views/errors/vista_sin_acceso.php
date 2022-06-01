<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Error: Sin acceso',
                    'css'           => array (
                    						                                                                                                               
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array (),
                        'titulo'        => 'Error de Acceso' ,
                        'titulo_icono'  => '',
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
                      <h3 class="h4"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error</h3>
                    </div>
                    <div class="card-body">
               			<center> <h3>No tiene permiso para ver esta area</h3></center><br><br><br>
               			<span>Contacte con el administrador del sitio</span>
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
                    					  
                    					  
                    					  //librería general
                    					  'recursos/gestores/ciclos/js/registrar.js', 
                    					                                                                                  
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

           
