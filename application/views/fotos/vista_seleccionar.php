<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Listar solicitudes',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						   'librerias/select2/dist/css/select2-bootstrap4.min.css',
                    						    //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                    					   		//dataTable(bs4)
                    					   		 //'librerias/datatables(bs4)_1.10.16/dataTables.bootstrap4.min.css'  ,  
                    					   		 //dataTable(1.10.16 min)
                    					   		 'librerias/datatables_1.10.16/datatables.min.css'  ,                    		
                    					   		
                    						   
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Fotos' => '' , 'Seleccionar' => '#' ),
                        'titulo'        => 'FOTOS: Seleccionar solicitud' ,
                        'titulo_icono'  => 'fa fa-picture-o',
                        'descripcion'   => 'Seleccione una solicitud para registrar las fotos correspondientes'

                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  

  <!-- Section de contenido-->
      <section class="" style="padding: 15px 0px;">
        <div class="container-fluid">

            <!-- filtros -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-header">
                            <h3 class="h5"><i class="fa fa-filter" aria-hidden="true"></i> Filtros</h3>

                            <div class="card-close pull-right">
                                <a data-toggle="collapse" href="#card_filtros" aria-expanded="true">
					          		<span class="mi_icon_open">
								         <i class="fa fa-chevron-down"></i>
								    </span>
                                    <span class="mi_icon_close">
								         <i class="fa fa-chevron-up"></i>
								    </span>
                                </a>                                &nbsp;
                                <a class="remove" href="#">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div  class="card-body collapse show" id="card_filtros" >
                            <!-- Filtro Agencias-->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Agencia</label>
                                <div class="col-sm-5">
                                    <?= $select_agencias  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Fin fila filtros -->

          <!-- tabla -->
          <div class="row justify-content-center">          	
          	 <!--empieza contenido lado izquierdo-->             
                 <!--empieza contenido lado derecho-->
                 <div class="col-md-11">
                 <div class="card">
                    <div class="card-header d-flex align-items-center">
                     <h3 class="h4"><i class="fa fa-list" aria-hidden="true"></i> Listado de Solicitudes</h3>

                    </div>                  

                    <div class="card-body">
                    	<div class="table-responsive">
                    		 <table id="listado_solicitudes" class="display nowrap table table-striped table-bordered">
	      					<!--cabesera de la tabla-->
		       					<thead>
		            				<tr>
                                        <th>Código</th>
										<th>DNI</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Estado</th>
                                        <th>Agencia</th>

										<th>Seleccionar</th>
                                        <th>id_estado</th>
		          					  </tr>
		      			        </thead>
		       					<!--cuerpo de la tabla-->
								<tbody>	
								 </tbody>
		   				 	 </table>
                    	</div>
						                   
                    </div>
				   </div>

                </div>
                <!--termina contenido lado derecho-->        
         	
         	
         	
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
                    					   //datatable                                       
	                                      'librerias/datatables_1.10.16/datatables.min.js' ,
	                                      'librerias/datatables_1.10.16/datatables_lenguaje.js',
	                                      
	                                      'recursos/fotos/js/listar_seleccionar_solicitudes.js' ,
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
<?php } else if ($estado_registro == 'solicitud_aprobada' && isset($estado_registro) ){ ?>
    <script>
    swal( 'Solicitud APROBADA','', "success");
    </script>
<?php  } else if ($estado_registro == 'solicitud_rechazada' && isset($estado_registro) ){ ?>
        <script>
            swal( 'Solicitud RECHAZA','', "success");
        </script>
<?php  } ?>
