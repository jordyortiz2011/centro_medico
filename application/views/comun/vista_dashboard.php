<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Panel Control',
                    'css'           => array (
                    						   //nombre hoja
                    						   'assets/css/jquery-ui.custom.min.css',
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Panel Control' => '#' ),
                        'titulo'        => 'Panel Control' ,
                        'titulo_icono'  => 'fa fa-tachometer',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="" style="padding: 15px 0px;">
        <div class="container-fluid">
          <div class="row">
          	
          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12">
              <div class="line-chart-example card">
                <div class="card-close">
                  <div class="dropdown">

                  </div>
                </div>
                <div class="card-header d-flex align-items-center">
                  <h3 class="h4">Panel de Control</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bienvenido: </h5>
                                    <p> <?= $usuario->nombres_user. ', '. $usuario->apellido_pat_user .' ' . $usuario->apellido_mat_user  ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <br> <br> <br> <br>
                </div>
              </div>
            </div>
         	
         	
         	
          </div>
        </div>
      </section>

<!-- 3 =============       FOOTER          ========================= -->
<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						 //Librería
                						 'assets/js/chosen.jquery.min.js',                                                                                
                                       )
                );  
    
    $this->load->view('template/f_footer', $data);
?>
           
