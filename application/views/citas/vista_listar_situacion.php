<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Listar Situación de estudiantes ',
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
                        'navegacion'    => array ('Principal'  => '' , 'Pagos' => '' , 'Situación de estudiantes' => '#' ),
                        'titulo'        => 'Listar Situación de estudiantes' ,
                        'titulo_icono'  => 'fa fa-usd',
                        'descripcion'   => 'Muestra en qué situación se encuentran los  pagos de los estudiantes, ya sea  cancelado o con deuda'
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  
  
<!-- 2 =============     CUERPO     ======================= -->  

  <!-- Section de contenido-->
      <section class="" style="padding: 15px 0px;">
        <div class="container-fluid">
        	
        	 <!-- filtros -->
        	 <div class="row justify-content-center">
        	 	<div class="col-md-10">
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
					        	</a>
					        	&nbsp;
					        	<a class="remove" href="#">					        		
					          		 <i class="fa fa-times"></i>					          		
					        	</a>				        	
		                	 </div>			                
					    </div>
					    <div  class="card-body collapse show" id="card_filtros" >
					    	<!-- Filtro tipo de colegio-->
                            <form class="form-inline">

                                <div class="form-group">
                                    <label class="col-sm-3 form-control-label">Situación</label>
                                    <div class="col-sm-5">
                                        <select class="select2"  name="filtrado_situacion" id="filtrado_situacion" data-width="100%">
                                            <option value="" selected="">Todos</option>
                                            <option value="1" > <i class="fa fa-times"></i> Cancelado</option>
                                            <option value="2" >Debe</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-3 form-control-label">Ciclo</label>
                                  <div class="col-sm-5">
                                    <!--<select class="select2"  name="filtrado_ciclo" id="filtrado_ciclo" data-width="100%">
                                        <option value="" selected="">Todos</option>
                                        <?php foreach ($lst_ciclos as $ciclo) {?>
                                              <option value="<?= $ciclo->id_ciclo ?>"><?= $ciclo->codigo_ciclo ?></option>
                                        <?php } ?> -->
                                      <?= $select_ciclos; ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 form-control-label">Turno</label>
                                    <div class="col-sm-5" id="contenedor_select_turnos">
                                        <select class="select2"  name="filtrado_turno" id="filtrado_turno" data-width="100%">
                                            <option value="" selected="">Todos</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filtro Aula-->
                                <div class="form-group ">
                                    <label class="col-sm-3 form-control-label">Aula</label>
                                    <div class="col-sm-5" id="contenedor_select_aulas">
                                        <select name="filtrado_aula" id="filtrado_aula">
                                            <option value="">Todos</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <div class="row justify-content-end">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-secondary" href="#" id="btn_exportar_excel_situacion" >
                                        <i class="text-green fa fa-file-excel-o "></i> <b>Exportar </b>
                                    </button>
                                </div>
                            </div>
					       
					    </div>
					</div>
				</div>
			</div>
        	
        	 
        	
          <!-- tabla -->
          <div class="row justify-content-center">          	
          	 <!--empieza contenido lado izquierdo-->             
                 <!--empieza contenido lado derecho-->
                 <div class="col-md-12">
                 <div class="card">
                    <div class="card-header d-flex align-items-center">
                     <h3 class="h4"><i class="fa fa-list" aria-hidden="true"></i> Listado</h3>

                    </div>                  

                    <div class="card-body">
                    	<div class="table-responsive">
                    		 <table id="listado_matriculas" class="display nowrap table table-striped table-bordered">
	      					<!--cabesera de la tabla-->
		       					<thead>
		            				<tr>
                                        <th>id registro</th>
										<th>Código</th>
                                        <th>Situación</th>
										<th>Estudiante</th>
                                        <th>Turno </th>
                                        <th>Aula </th>
                                        <th>Modalidad de Pago</th>
										<th>TOTAL A PAGAR</th>
                                        <th>Importe total</th>
                                        <th>Saldo </th>
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
                                            //PARA EL SPIN (animacion hasta esperar el procesamiento)
                                            'librerias/spin/spin.min.js',
                                            'librerias/spin/spin_variables.js',
	                                      
	                                      'recursos/pagos/js/listar_situacion.js' ,
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
<?php } else if ($estado_registro == 'registro_error' && isset($estado_registro) ) { ?>
    <script>
        swal( 'Error al registrar','', "error");
    </script>
<?php }  ?>
