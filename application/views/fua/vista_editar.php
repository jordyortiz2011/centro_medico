<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Solicitud Ver',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						   //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                //datetimepicker
                                                'librerias/datetimepicker/bootstrap-datetimepicker.min.css',
                                                'librerias/datetimepicker/color_dias_bloqueado.css',
                    						   
                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Solicitud' => '' , 'Listar' => '#' , 'Ver' => '#' ),
                        'titulo'        => 'SOLICITUD DE CRÉDITO (Ver)' ,
                        'titulo_icono'  => 'fa fa-file-text-o',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  

<style>
    .form-control{
        padding: 5px 10px !important;
    }
</style>
<!-- 2 =============     CUERPO     ======================= -->  
  <!-- Section de contenido-->
      <section class="">
        <div class="container-fluid">
          <div class="row">
          	
          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12">
              <div class="line-chart-example card">
                <div class="card-close">
                  <div class="dropdown">
                    <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                    <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
                        <?php if ($auth_level ==  9) { ?>
                        <a href="<?= base_url('solicitud/exportar/excel_reporte_solicitud/').$solicitud->id_soli ?>" class="dropdown-item "> <i class="fa fa-file-excel-o"></i>Exportar Excel </a>

                        <?php } ?>
                        <a href="<?= base_url('solicitud/exportar/pdf_reporte_solicitud/').$solicitud->id_soli ?>" class="dropdown-item " target="_blank"> <i class="fa fa-file-pdf-o"></i>Exportar PDF </a>

                    </div>
                  </div>
                </div>
                <div class="card-header d-flex align-items-center">
                    <img src="<?= base_url('public/assets/img/logo_nuevo_prisma_pequeno.jpg') ?>" width="227px"  height="51px">  &nbsp;
                    <h3>Ficha Socioecónomica - Prisma cultivo </h3>
                    &nbsp;<?= $estado_solicitud ?>
                </div>
                <div class="card-body">
                    <!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                    <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?>
                    <br>
                    <form method="POST" id="form_editar_solicitud" action="<?= base_url('solicitud/editar/procesa_editar') ?>">
                        <input type="hidden" name="hidd_id_solicitud" value="<?= $solicitud->id_soli ?> " />
                      

					<div class="row align-items-center">
 					    <div class="col-md-4 form-group">
                               <input type="text"   required="" class="input-material " readonly="" value="<?= $fecha_convertido ?>">
                               <label for="text_fecha_solicitud" class="label-material active"   style="left: 15px;">Fecha de solicitud</label>
                           </div>
                        <div class="col-md-4 form-group">
                            <label for="select_agencias"  class="label-material active ">Agencia <span class="text-danger">*</span></label>
                            <?= $select_agencias ?>
                        </div>
						  <div class="col-md-4 form-group ">
                              <input  type="text" name="text_asesor_credito" id="text_asesor_credito" required="" class="input-material" readonly="" value="<?= $solicitud->nombre_user_asesor_destino_soli ?>">
                              <label for="text_asesor_credito" class="label-material active" style="left: 15px;">Asesor de crédito</label>
						  </div>
                    </div><!-- FIN ROW -->
                   <br>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <?php if($solicitud->fecha_verificacion_soli == '' || $solicitud->fecha_verificacion_soli == NULL ) { ?>
                            <input type="text"    required="" class="input-material" autocomplete="off" value="Por definir" readonly>
                            <?php } else { ?>
                            <input type="text"    required="" class="input-material" autocomplete="off" value="<?= fecha_transformar_fecha($solicitud->fecha_verificacion_soli) ?>" readonly>
                            <?php }  ?>
                            <label for="fecha_aprobacion" class="label-material active" style="left: 15px;">Fecha de Aprobación</label>
                        </div>
                        <?php if ($solicitud->nombre_user_articulador_soli !=  NULL || $solicitud->nombre_user_articulador_soli != '' ) {?>
                            <div class="col-md-4 form-group">
                                <!--<label for="select_agencias"  class="label-material active ">Asesor de crédito <span class="text-danger">*</span></label>
                                <select id="select_asesores" name="select_asesores" class=' form-control' >
                                    <option>Seleccione</option>
                                </select> -->

                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="text_asesor_credito"  id="text_asesor_credito"   class="input-material"  value="<?= $solicitud->nombre_user_articulador_soli ?>" readonly>
                                <label for="text_asesor_credito" class="label-material active" style="left: 15px;">Nombre de articulador</label>
                            </div>
                        <?php }?>
                    </div><!-- FIN ROW -->


                   <h4 class="h3">Datos Personales</h4> <hr>
                   <!-- fila DEL TITULAR -->
                   <div class="row">
                   		<div class="col-md-2  form-group row">
						    <label for="staticEmail" class="col-md-12 col-form-label"> <strong>TITULAR </strong> </label>
						</div>

                           <div class="col-md-2 form-group">
                               <input type="text" name="text_nombres_titular"  id="text_nombres_titular"  required="" class="input-material " readonly="" value="<?= $solicitud->nombres_titular_soli ?>">
                               <label for="text_nombres_titular" class="label-material active"   style="left: 15px;">Nombres</label>
                           </div>
						  <div class="col-md-2 form-group ">
                              <input  type="text" name="text_apellido_pat_titular" id="text_apellido_pat_titular" required="" class="input-material" readonly="" value="<?= $solicitud->apellido_pat_titular_soli ?>">
                              <label for="text_apellido_pat_titular" class="label-material active" style="left: 15px;">Apellido Paterno</label>
						  </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                           <div class="col-md-2 form-group ">
                               <input  type="text" name="text_apellido_mat_titular" id="text_apellido_mat_titular" required="" class="input-material" readonly="" value="<?= $solicitud->apellido_mat_titular_soli ?>">
                               <label for="text_apellido_mat_titular" class="label-material active" style="left: 15px;">Apellido Materno</label>
                           </div>
                           <div class="col-md-2 form-group ">
                               <input  type="text" name="text_dni_titular" id="text_dni_titular" required="" maxlength="8" class="input-material" readonly="" value="<?= $solicitud->dni_titular_soli ?>">
                               <label for="text_dni_titular" class="label-material active"  style="left: 15px;">DNI</label>
                           </div>&nbsp;&nbsp;&nbsp;&nbsp;

                   </div><!-- FIN ROW -->
                   <br>
                    <!-- fila -->
                   <div class="row">
                       <div class="col-md-1 form-group row">
                          &nbsp;
                       </div>

                       <div class="col-md-3 form-group">
                           <input type="text" name="text_fecha_naci_titular" id="text_fecha_naci_titular"  required="" class="input-material" readonly="" value="<?= $solicitud->fecha_naci_titular_soli ?>">
                           <label for="text_fecha_naci_titular" class="label-material active" style="left: 15px;">Fecha de Naci. </label>
                       </div>
                       <div class="col-md-2 form-group">
                           <label for="text_fecha_naci_titular" class="label-material active" style="left: 15px;">Edad </label>
                           <span id="text_fecha_naci_titular_edad"></span>
                       </div>
                       <div class="col-md-3 form-group row">
                           <div class="col-md-12">
                               <label class="label-material" style="left: 15px;">Estado civil </label>
                               <?= $select_estado_civil ?>
                           </div>
                       </div>
                       <div class="col-md-3 form-group">
                           <br>
                           <input type="text" name="text_num_hijos" id="text_num_hijos"   required="" class="input-material" readonly="" value="<?= $solicitud->numero_hijos_soli ?>">
                           <label for="text_num_hijos" class="label-material active" style="left: 15px; top:5px">Nº de Hijos</label>
                       </div>
                         <!--<div class="col-md-3 form-group row">
                            <div class="col-md-12">
                               <label class="label-material" style="left: 15px;">Calif. Ult.12 mes: </label>
                                <?= $select_cali ?>
                            </div>
                        </div>-->

                   </div><!-- FIN ROW -->
                    <br>
                    <!-- ROWW-->
                    <div class="row">
                        <div class="col-md-1 form-group row">

                        </div>
                        <div class="col-md-3 form-group">
                            <label class="label-material" style="left: 15px;">Tenencia de vivienda </label>
                            <?= $select_tenencia_vivienda ?>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="label-material" style="left: 15px;">Servicios Básicos </label>
                            <?= $select_servicios_basicos ?>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_celular_titular"  id="text_celular_titular" required="" maxlength="9" class="input-material" readonly="" value="<?= $solicitud->celular_titular_soli ?>">
                            <label for="text_celular_titular" class="label-material active" style="left: 15px;">Celular</label>
                        </div>
                        <div class="col-md-3 form-group row">
                            <div class="col-md-12">
                                <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                                <?= $select_grado ?>
                            </div>
                        </div>
                    </div><!-- FIN ROW -->
                    <br>
                    <!-- fila -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 form-group row">
                            <div class="col-md-12">
                                <label class="label-material" style="left: 15px;">Departamento </label>
                                <?= $select_departamentos ?>
                            </div>
                        </div>
                        <div class="col-md-3 form-group row">
                            <div class="col-md-12" id="contenedor_select_provincias">
                                <label class="label-material" style="left: 15px;">Provincia </label>
                                <?= $select_provincias ?>
                            </div>
                        </div>
                        <div class="col-md-3 form-group row">
                            <div class="col-md-12" id="contenedor_select_distritos">
                                <label class="label-material" style="left: 15px;">Distrito </label>
                                <?= $select_distritos ?>
                            </div>
                        </div>
                        <!--<div class="col-md-2 form-group">
                            <input type="text" name="text_caserio_titular"  id="text_caserio_titular"   class="input-material" autocomplete="off" value="<?= $solicitud->nombre_caserio_titular_soli ?>" readonly>
                            <label for="text_caserio_titular" class="label-material active" style="left: 15px;">Caserío</label>
                        </div>-->
                    </div><!-- FIN ROW -->
                    <br>
                    <!-- fila -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-md-5 form-group ">
                            <label for="text_direccion" class="label-material" style="left: 15px;">Dirección del domicilio</label>
                            <input type="text" name="text_direccion" id="text_direccion"  style="left: 15px;" required="" class="input-material" autocomplete="off" value="<?= $solicitud->direccion_soli ?>">
                        </div>
                        <div class="col-md-5 form-group ">
                            <label for="text_direccion_terreno" class="label-material" style="left: 15px;">Dirección del terreno agrícola</label>
                            <input type="text" name="text_direccion_terreno" id="text_direccion_terreno"  style="left: 15px;" required="" class="input-material" autocomplete="off" value="<?= $solicitud->direccion_terreno_soli ?>">
                        </div>
                    </div><!-- FIN ROW -->
                    <br>
                    <!-- fila  ACTIVIDAD PRINCIPAL TITULAR -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="label-material active" style="left: 15px;">Actividad Principal </label>
                            <input type="text" name="text_actividad_principal_titular"  id="text_actividad_principal_titular"   class="input-material" autocomplete="off" readonly value="<?= $solicitud->actividad_principal_titular_soli ?>">
                        </div>
                        <div class="col-md-3 form-group ">
                            <label class="label-material" style="left: 15px;">Tenencia de local o terreno </label>
                            <?= $select_terreno_principal_titular ?>
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="label-material active" style="left: 15px;">Area Mts o HAS </label>
                            <input type="text" name="text_area_principal_titular"  id="text_area_principal_titular"   class="input-material" autocomplete="off" readonly  value="<?= $solicitud->area_principal_titular_soli ?>">
                        </div>
                    </div><!-- FIN ROW -->
                    <br>

                    <!-- fila ACTIVIDAD SECUNDARIA TITULAR -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="label-material active" style="left: 15px;">Actividad Secundaria  </label>
                            <input type="text" name="text_actividad_secundaria_titular"  id="text_actividad_secundaria_titular"   class="input-material" autocomplete="off" readonly value="<?= $solicitud->actividad_secundaria_titular_soli ?>">
                        </div>
                        <div class="col-md-3 form-group ">
                            <label class="label-material" style="left: 15px;">Tenencia de local o terreno </label>
                            <?= $select_terreno_secundaria_titular ?>
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="label-material active" style="left: 15px;">Area Mts o HAS </label>
                            <input type="text" name="text_area_secundaria_titular"  id="text_area_secundaria_titular"   class="input-material" autocomplete="off"  readonly value="<?= $solicitud->area_secundaria_titular_soli ?>">
                        </div>
                    </div><!-- FIN ROW -->

                    <!-- Títular - tipo de socio -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;&nbsp;
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="label-material" style="left: 15px;">Tipo de Socio </label>
                            <?= $select_tipo_socio ?>
                        </div>

                        <?php if ($id_tipo_socio == 2) { ?>
                            <div class="col-md-3 form-group" id="bloque_numero_creditos">
                                <label for="text_numero_creditos" class="label-material" style="left: 15px;">Número de créditos</label>

                                <input type="text" name="text_numero_creditos" id="text_numero_creditos"  required="" class="input-material solo_numeros" autocomplete="off" value="<?= $solicitud->numero_creditos_soli ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <br>

                    <!-- USTED VENDE SU PRODUCCIÓN A:  -->
                    <div class="row">

                        <label  class="label-material" style="left: 15px;">&nbsp;&nbsp; Ud. Vende su Producción a:</label>
                        &nbsp; &nbsp; &nbsp;
                        <div class="col-md-2">
                            <!--<input class="form-check-input" type="checkbox" value="1" id="checkbox_asociacion" name="checkbox_vende_produccion[]"> -->
                            <?= $checkbox_vende_produccion['asociacion'] ?>
                            <label class="form-check-label" for="checkbox_asociacion" style="padding-left: 0px;">Asociación </label>
                        </div>
                        <div class="col-md-2">
                            <?= $checkbox_vende_produccion['cooperativa'] ?>
                            <label class="form-check-label" for="checkbox_cooperativa" style="padding-left: 0px;">Cooperativa</label>
                            <!--<input class="form-check-input" type="checkbox" value="2" id="checkbox_cooperativa" name="checkbox_vende_produccion[]"> -->
                        </div>
                        <div class="col-md-2">
                            <?= $checkbox_vende_produccion['comite'] ?>
                            <label class="form-check-label" for="checkbox_comite" style="padding-left: 0px;">Comité Productor </label>
                        </div>
                        <div>
                            <!--<input class="form-check-input" type="checkbox" value="4" id="checkbox_intermediario" name="checkbox_vende_produccion[]">-->
                            <?= $checkbox_vende_produccion['intermediario'] ?>
                            <label class="form-check-label" for="checkbox_intermediario" style="padding-left: 0px;">Intermediario </label>
                        </div>
                        <br><span style="margin-left: 20px" id="error_checkbox_vende_produccion"> </span>


                    </div> <!-- fin fila vende producción-->

                    <hr>

                    <?php if ($solicitud->id_estado_civil_soli == 2 || $solicitud->id_estado_civil_soli == 4 ) { ?>
                    <!-- fila DEL CONYUGUE -->
                    <div class="row  align-items-center">
                        <div class="col-md-2  form-group row">
                            <label for="staticEmail" class="col-md-12 col-form-label"> <strong>CÓNYUGE </strong> </label>
                        </div>

                        <div class="col-md-2 form-group">
                            <input id="text_nombres_conyugue" type="text" name="text_nombres_conyugue" required="" class="input-material" readonly="" value="<?= $solicitud->nombres_conyugue_soli ?>">
                            <label for="text_nombres_conyugue" class="label-material active" style="left: 15px;">Nombres</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_pat_conyugue" type="text" name="text_apellido_pat_conyugue" required="" class="input-material" readonly=""  value="<?= $solicitud->apellido_pat_conyugue_soli ?>">
                            <label for="text_apellido_pat_conyugue" class="label-material active" style="left: 15px;">Apellido Paterno</label>
                        </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_mat_conyugue" type="text" name="text_apellido_mat_conyugue" required="" class="input-material" readonly="" value="<?= $solicitud->apellido_mat_conyugue_soli ?>">
                            <label for="text_apellido_mat_conyugue" class="label-material active" style="left: 15px;">Apellido Materno</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_dni_conyugue" type="text" name="text_dni_conyugue" required="" maxlength="8" class="input-material" readonly="" value="<?= $solicitud->dni_conyugue_soli ?>">
                            <label for="text_dni_conyugue" class="label-material active" style="left: 15px;">DNI</label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;

                    </div><!-- FIN ROW -->
                    <br>
                                          
                    <!-- fila -->
                    <div class="row  align-items-center">
                        <div class="col-md-1 form-group row">
                            &nbsp;
                        </div>
                        <div class="col-md-2 form-group row">
                            <div class="col-md-12">
                                <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                                <?= $select_grado_conyugue ?>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_fecha_naci_conyugue" id="text_fecha_naci_conyugue"  required="" class="input-material" readonly="" value="<?= $solicitud->fecha_naci_conyugue_soli ?>">
                            <label for="text_fecha_naci_conyugue" class="label-material active" style="left: 15px;">Fecha de Nacimiento</label>
                        </div>
                        <div class="col-md-1 form-group">
                            <label for="text_fecha_naci_conyugue_edad" class="label-material active" style="left: 15px;">Edad </label>
                            <span id="text_fecha_naci_conyugue_edad"></span>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_celular_conyugue"  id="text_celular_conyugue" required="" maxlength="9" class="input-material" readonly="" value="<?= $solicitud->celular_conyugue_soli ?>">
                            <label for="text_celular" class="label-material active" style="left: 15px;">Celular</label>
                        </div>

                    </div><!-- FIN ROW -->
                    <br>

                    <hr>
                    <?php } ?>

                    <!-- fila DEL AVAL -->
                    <?php if($solicitud->id_posee_aval_soli == 1 ) { ?>

                    <div class="row">
                        <div class="col-md-2  form-group row">
                            <label for="staticEmail" class="col-md-12 col-form-label"> <strong>AVAL </strong> </label>
                        </div>

                        <div class="col-md-2 form-group">
                            <input id="text_nombres_aval" type="text" name="text_nombres_aval" required="" class="input-material" readonly="" value="<?= $solicitud->nombres_aval_soli ?>">
                            <label for="text_nombres_aval" class="label-material active" style="left: 15px;">Nombres</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_pat_aval" type="text" name="text_apellido_pat_aval" required="" class="input-material" readonly=""  value="<?= $solicitud->apellido_pat_aval_soli ?>">
                            <label for="text_apellido_pat_aval" class="label-material active" style="left: 15px;">Apellido Paterno</label>
                        </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_mat_aval" type="text" name="text_apellido_mat_aval" required="" class="input-material" readonly="" value="<?= $solicitud->apellido_mat_aval_soli ?>">
                            <label for="text_apellido_mat_aval" class="label-material active" style="left: 15px;">Apellido Materno</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_dni_aval" type="text" name="text_dni_aval" required="" maxlength="8" class="input-material" readonly="" value="<?= $solicitud->dni_aval_soli ?>">
                            <label for="text_dni_aval" class="label-material active" style="left: 15px;">DNI</label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;

                    </div><!-- FIN ROW -->
                    <br>
                       <!-- fila -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;
                        </div>
                        <div class="col-md-2 form-group ">
                            <input type="text" name="text_direccion_aval" id="text_direccion_aval"  style="left: 15px;" required="" class="input-material" autocomplete="off" readonly="" value="<?= $solicitud->direccion_aval_soli ?>">
                            <label for="text_direccion_aval" class="label-material active" style="left: 15px;">Dirección del domicilio</label>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_fecha_naci_aval" id="text_fecha_naci_aval"  required="" class="input-material" readonly="" value="<?= $solicitud->fecha_naci_aval_soli ?>">
                            <label for="text_fecha_naci_aval" class="label-material active" style="left: 15px;">Fecha de Nacimiento</label>
                        </div>
                        <div class="col-md-1 form-group">
                            <label for="text_fecha_naci_aval_edad" class="label-material active" style="left: 15px;">Edad </label>
                            <span id="text_fecha_naci_aval_edad"></span>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_celular_aval"  id="text_celular_aval" required="" maxlength="9" class="input-material" readonly="" value="<?= $solicitud->celular_aval_soli ?>">
                            <label for="text_celular_aval" class="label-material active" style="left: 15px;">Celular</label>
                        </div>
                      <!--<div class="col-md-2 form-group row">
                            <div class="col-md-12">
                              <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                                <?= $select_grado_aval ?>
                            </div>
                        </div>-->
                    </div><!-- FIN ROW -->
                    <br>

                    <hr>
                    <!-- fila DEL CONYUGUE DEL AVAL -->
                    <div class="row">
                        <div class="col-md-2  form-group row">
                            <label for="staticEmail" class="col-md-12 col-form-label"> <strong>CÓNYUGUE DEL AVAL </strong> </label>
                        </div>

                        <div class="col-md-2 form-group">
                            <input id="text_nombres_conyu_aval" type="text" name="text_nombres_conyu_aval" required="" class="input-material" readonly="" value="<?= $solicitud->nombres_conyu_aval_soli ?>">
                            <label for="text_nombres_conyu_aval" class="label-material active" style="left: 15px;">Nombres</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_pat_conyu_aval" type="text" name="text_apellido_pat_conyu_aval" required="" class="input-material" readonly=""  value="<?= $solicitud->apellido_pat_conyu_aval_soli ?>">
                            <label for="text_apellido_pat_conyu_aval" class="label-material active" style="left: 15px;">Apellido Paterno</label>
                        </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="col-md-2 form-group ">
                            <input id="text_apellido_mat_conyu_aval" type="text" name="text_apellido_mat_aval" required="" class="input-material" readonly="" value="<?= $solicitud->apellido_mat_conyu_aval_soli ?>">
                            <label for="text_apellido_mat_conyu_aval" class="label-material active" style="left: 15px;">Apellido Materno</label>
                        </div>
                        <div class="col-md-2 form-group ">
                            <input id="text_dni_conyu_aval" type="text" name="text_dni_conyu_aval" required="" maxlength="8" class="input-material" readonly="" value="<?= $solicitud->dni_conyu_aval_soli ?>">
                            <label for="text_dni_conyu_aval" class="label-material active" style="left: 15px;">DNI</label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;

                    </div><!-- FIN ROW -->
                    <br>
                    <!-- fila -->
                    <div class="row">
                        <div class="col-md-1 form-group row">
                            &nbsp;
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" name="text_fecha_naci_aval" id="text_fecha_naci_aval"  required="" class="input-material" readonly="" value="<?= $solicitud->fecha_naci_conyu_aval_soli ?>">
                            <label for="text_fecha_naci_aval" class="label-material active" style="left: 15px;">Fecha de Nacimiento</label>
                        </div>

                        <div class="col-md-2 form-group">
                            <input type="text" name="text_celular_aval"  id="text_celular_aval" required="" maxlength="9" class="input-material" readonly="" value="<?= $solicitud->celular_conyu_aval_soli ?>">
                            <label for="text_celular_aval" class="label-material active" style="left: 15px;">Celular</label>
                        </div>
                        <!--<div class="col-md-2 form-group row">
                        <div class="col-md-12">
                          <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                            <?= $select_grado_aval ?>
                        </div>
                    </div>-->
                        <br>
                    </div><!-- FIN ROW -->
                     <?php } ?> <!-- Fin verificación posee aval -->

                    <hr>
                    <h4 class="h3" >Deuda sistema financiero</h4> <hr>
                        <!-- Deuda sistema financiero titular -->
                        <b>&nbsp;&nbsp;&nbsp;<u>Títular: </u></b> <hr>
                        <!-- Deuda sistema financiero -->
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <div class="col-md-1">
                                    </div>
                                    <label class="col-md-6 form-control-label"> ¿Registra DUD, DEF o PER en los últimos 24 meses?</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <?=  $select_registra_deuda_titular ?>
                                            <input type="hidden" name="hidden_registra_deuda_titular" id="hidden_registra_deuda_titular">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label">Documentos Impagos</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">S/</span>
                                            <input type="text" class="form-control" id="text_impagos_titular" name="text_impagos_titular" readonly value="<?= $solicitud->impagos_titular_soli  ?>"  >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label">Protestos</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">S/</span>
                                            <input type="text" class="form-control"  id="text_protestos_titular" name="text_protestos_titular" readonly value="<?= $solicitud->protestos_titular_soli  ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group ">
                                <div class="float-right">
                                    <!--<a id="addrow_deuda_titular" type="button" class="btn btn-info"  href="#/" >
                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                    </a> -->

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tabla_deuda_titular">
                                        <thead>
                                        <tr>
                                            <th>Nombre entidad</th>
                                            <th>Fecha Información</th>
                                            <th>Saldo de deuda a la fecha (S/)</th>
                                            <th>Última calificación reportada</th>
                                            <th>Peor Calificación en los últ. 12 meses </th>
                                            <th>Saldo de deuda a la fecha </th>
                                            <th>Cuota Pendiente (S/) </th>
                                            <th>Cuotas pendientes</th>
                                            <th><!-- Opción Remover --> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php   $total_deuda_consulta = 0 ;
                                                $total_deuda_evaluacion = 0 ;
                                                $total_cuota_pendiente = 0;
                                        foreach ($tabla_deuda_titular as $indice => $valor)  {

                                             //Convertif formato fecha
                                            $originalDate = $valor->fecha_consulta_deuti;
                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][entidad]"              class="form-control form-control-sm " autocomplete="off"        value="<?= $valor->entidad_deuti ?>" readonly  style="width: 15em;" >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][fecha_consulta]"       class="form-control form-control-sm " autocomplete="off" value="<?= $newDate ?>"  readonly style="width: 8em;" >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][saldo_deuda_consulta]"  class="form-control form-control-sm solo_numeros" autocomplete="off" value="<?= $valor->saldo_deuda_consulta_deuti ?>"  readonly style="width: 8em;" >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][ultima_calificacion]"   class="form-control form-control-sm " autocomplete="off"  value="<?= $valor->ultima_calificacion_deuti ?>" readonly  style="width: 5em;" >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][peor_calificacion]"       class="form-control form-control-sm "  autocomplete="off"  value="<?= $valor->peor_calificacion_deuti ?>" readonly style="width: 5em;" >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][saldo_deuda_evaluacion]"  class="form-control form-control-sm solo_numeros" autocomplete="off"  value="<?= $valor->saldo_deuda_evaluacion_deuti ?>" readonly style="width: 10em;">
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][cuota_pendiente]"          class="form-control form-control-sm solo_numeros" autocomplete="off" value="<?= $valor->cuota_pendiente_deuti  ?>" readonly style="width: 10em;"  >
                                                </td>
                                                <td>
                                                    <input type="text" name="text_tabla_deuda_titular[0][num_cuotas_pendiente]"     class="form-control form-control-sm solo_numeros"  autocomplete="off" value="<?= $valor->num_cuotas_pendiente_deuti ?>"  readonly style="width: 5em;"  >
                                                </td>
                                                <td>
                                                    <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                                        <i class='fa fa-trash-o bigger-150'></i>
                                                    </a>-->
                                                </td>
                                            </tr>
                                        <?php   $total_deuda_consulta   += $valor->saldo_deuda_consulta_deuti;
                                                $total_deuda_evaluacion += $valor->saldo_deuda_evaluacion_deuti;
                                                $total_cuota_pendiente  += $valor->cuota_pendiente_deuti;} ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-center"> <b>TOTAL</b>  </td>
                                            <td class="text-center">
                                                <h4 id="sumatoria_deuda_consulta_titular"> <?= $total_deuda_consulta ?> </h4>
                                            </td>
                                            <td> &nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td class="text-center">
                                                <h4 id="sumatoria_deuda_evaluacion_titular"> <?= $total_deuda_evaluacion ?> </h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 id="sumatoria_cuota_pendiente_titular"> <?= $total_cuota_pendiente ?></h4>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- fin table responsive -->
                            </div>
                    </div><!-- FIN ROW -->

                                <!-- Deuda sistema financiero conyuge -->
                        <?php if ($solicitud->id_estado_civil_soli == 2 || $solicitud->id_estado_civil_soli == 4 ) { ?>

                        <b><u>Cónyuge: </u></b> <hr>
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <div class="col-md-1" ></div>
                                            <label class="col-md-6 ">¿Registra DUD, DEF o PER en los últimos 24 meses?</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <?=  $select_registra_deuda_conyuge ?>
                                                    <input type="hidden" name="hidden_registra_deuda_conyuge" id="hidden_registra_deuda_conyuge" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-md-4 form-control-label">Documentos Impagos</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">S/</span>
                                                    <input type="text" class="form-control" id="text_impagos_conyuge" name="text_impagos_conyuge" readonly value="<?= $solicitud->impagos_conyuge_soli ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-md-4 form-control-label">Protestos</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">S/</span>
                                                    <input type="text" class="form-control"   id="text_protestos_conyuge" name="text_protestos_conyuge" readonly value="<?= $solicitud->protestos_conyuge_soli ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                        <div class="col-md-12 form-group ">
                                            <div class="float-right">
                                                <!--<a id="addrow_deuda_conyuge" type="button" class="btn btn-info"  href="#/" >
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                                </a> -->

                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="tabla_deuda_conyuge">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre entidad</th>
                                                        <th>Fecha Información</th>
                                                        <th>Saldo de deuda a la fecha (S/)</th>
                                                        <th>Última calificación reportada</th>
                                                        <th>Peor Calificación en los últ. 12 meses </th>
                                                        <th>Saldo de deuda a la fecha </th>
                                                        <th>Monto de la cuota (S/) </th>
                                                        <th>Cuotas pendientes</th>
                                                        <th><!-- Opción Remover --> </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php   $total_deuda_consulta = 0 ;
                                                    $total_deuda_evaluacion = 0 ;
                                                    $total_cuota_pendiente = 0;
                                                    foreach ($tabla_deuda_conyuge as $indice => $valor)  {

                                                        //Convertif formato fecha
                                                        $originalDate = $valor->fecha_consulta_deucon;
                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][entidad]"              class="form-control form-control-sm " autocomplete="off"        value="<?= $valor->entidad_deucon ?>" readonly  style="width: 15em;" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][fecha_consulta]"       class="form-control form-control-sm " autocomplete="off" value="<?= $newDate ?>"  readonly style="width: 8em;" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][saldo_deuda_consulta]"  class="form-control form-control-sm solo_numeros" autocomplete="off" value="<?= $valor->saldo_deuda_consulta_deucon ?>"  readonly style="width: 8em;" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][ultima_calificacion]"   class="form-control form-control-sm " autocomplete="off"  value="<?= $valor->ultima_calificacion_deucon ?>" readonly  style="width: 5em;" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][peor_calificacion]"       class="form-control form-control-sm "  autocomplete="off"  value="<?= $valor->peor_calificacion_deucon ?>" readonly style="width: 5em;" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][saldo_deuda_evaluacion]"  class="form-control form-control-sm solo_numeros" autocomplete="off"  value="<?= $valor->saldo_deuda_evaluacion_deucon ?>" readonly style="width: 10em;">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][cuota_pendiente]"          class="form-control form-control-sm solo_numeros" autocomplete="off" value="<?= $valor->cuota_pendiente_deucon  ?>" readonly style="width: 10em;"  >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="text_tabla_deuda_conyuge[0][num_cuotas_pendiente]"     class="form-control form-control-sm solo_numeros"  autocomplete="off" value="<?= $valor->num_cuotas_pendiente_deucon ?>"  readonly style="width: 5em;"  >
                                                            </td>
                                                            <td>
                                                                <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                                                    <i class='fa fa-trash-o bigger-150'></i>
                                                                </a>-->
                                                            </td>
                                                        </tr>
                                                        <?php   $total_deuda_consulta   += $valor->saldo_deuda_consulta_deucon;
                                                        $total_deuda_evaluacion += $valor->saldo_deuda_evaluacion_deucon;
                                                        $total_cuota_pendiente  += $valor->cuota_pendiente_deucon;} ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-center"> <b>TOTAL</b>  </td>
                                                        <td class="text-center">
                                                            <h4 id="sumatoria_deuda_consulta_conyuge"> <?= $total_deuda_consulta ?> </h4>
                                                        </td>
                                                        <td> &nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td class="text-center">
                                                            <h4 id="sumatoria_deuda_evaluacion_conyuge"> <?= $total_deuda_evaluacion ?> </h4>
                                                        </td>
                                                        <td class="text-center">
                                                            <h4 id="sumatoria_cuota_pendiente_conyuge"> <?= $total_cuota_pendiente ?></h4>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div><!-- fin table responsive -->
                                        </div>
                                    </div><!-- FIN ROW -->

                        <?php } ?>


                    <h4 class="h3">Diversificación de cultivo </h4> <hr>
                    <!-- Deuda sistema financiero -->
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <!--<div class="float-right">
                                <a id="addrow_cultivo" type="button" class="btn btn-info" href="#tabla_cultivo">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div> -->
                            <div class="table-responsive">
                            <table id="tabla_cultivo" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Cultivo</th>
                                    <th>Unidad</th>
                                    <th>Mes cosecha</th>
                                    <th>Ha Totales</th>
                                    <th>Ha Producción</th>
                                    <th>Rendimiento Kg / Ha</th>
                                    <th>Precio (S/.)</th>
                                    <th>Total(S/.)</th>
                                    <th><!-- Opción Remover --> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php   $total_cultivo = 0 ;
                                        foreach ($tabla_cultivo as $indice => $valor)  { ?>
                                <tr>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][cultivo]"  class="form-control form-control-sm" readonly  value="<?= $valor->cultivo_soli_c ?>" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][unidad]"  class="form-control form-control-sm "  readonly value="<?= $valor->unidad_soli_c ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][mes]"  class="form-control form-control-sm solo_fechas_mes"  readonly value="<?= $valor->mes_soli_c ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][ha_totales]"  class="form-control form-control-sm solo_numeros"  readonly value="<?= $valor->ha_totales_soli_c ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][ha_produccion]"  class="form-control form-control-sm solo_numeros" readonly  value="<?= $valor->ha_produccion_soli_c ?>" >
                                    </td>

                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][produccion]"  class="form-control form-control-sm solo_numeros"  readonly value="<?= $valor->produccion_soli_c ?>">
                                    </td>

                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][precio]"  class="form-control form-control-sm solo_numeros" readonly value="<?= $valor->precio_soli_c ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][total]"  class="form-control form-control-sm solo_numeros" readonly value="<?= $valor->total_c ?>">
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                <?php   $total_cultivo += $valor->total_c; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7" class="text-center"> <b>TOTAL</b>  </td>
                                    <td class="text-center">
                                        <h4 id="total_sumatoria_cultivo"> <?= $total_cultivo ?></h4>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            </div><!-- fin div.table_responsive-->
                        </div>
                    </div><!-- FIN ROW -->

                    <h4 class="h3">Diversificación Pecuaria </h4> <hr>
                    <!-- Deuda sistema financiero -->
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <!-- <div class="float-right">
                                <a id="addrow_pecuaria" type="button" class="btn btn-info" href="#tabla_pecuaria">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div> -->
                            <div class="table-responsive">
                            <table id="tabla_pecuaria" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th >Nombre</th>
                                    <th >Nº Animales</th>
                                    <th>Autoconsumo</th>
                                    <th>Nº animales venta</th>
                                    <th>Fecha venta</th>
                                    <th>Precio S/.</th>
                                    <th>Total S/.</th>
                                    <th><!-- Opción Remover --> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tabla_pecuaria as $indice => $valor)  { ?>
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_pecuaria[0][nombre]" readonly value="<?= $valor->nombre_soli_p ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][num_animales]" readonly value="<?= $valor->num_animales_soli_p ?>" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][autoconsumo]" readonly value="<?= $valor->autoconsumo_soli_p ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][num_animales_venta]" style="width: 5em;" readonly value="<?= $valor->num_animales_venta_soli_p ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_fechas" name="text_tabla_pecuaria[0][fecha_venta]" readonly value="<?= $valor->fecha_soli_pe ?>" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][precio]" readonly value="<?= $valor->precio_soli_p ?>" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros"  name="text_tabla_pecuaria[0][total]" readonly value="<?= $valor->total_soli_p ?>" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div><!-- FIN ROW -->

                    <!-- tabla derivados -->
                    <div class="row d-none">
                        <div class="col-md-6 form-group">
                            <h4 class="h3">Diversificación derivados </h4> <hr>
                            <!--<div class="float-right">
                                <a id="addrow_derivados" type="button" class="btn btn-info" href="#tabla_derivados">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>-->
                            <div class="table-responsive">
                            <table id="tabla_derivados" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Derivados</th>
                                    <th>Unidad</th>
                                    <th>Producción</th>
                                    <th>Precio S/.</th>
                                    <th>Fecha Ingreso </th>
                                    <th><!-- Opción Remover --> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tabla_derivados as $indice => $valor)  { ?>
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_derivados[0][derivados]" style="width: 8em;" readonly value="<?= $valor->derivados_soli_der ?>">
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_derivados[0][unidad]" readonly value="<?= $valor->unidad_soli_der ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_derivados[0][produccion]" readonly value="<?= $valor->produccion_soli_der ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_derivados[0][precio]" style="width: 6em;" readonly value="<?= $valor->precio_soli_der ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_fechas" name="text_tabla_derivados[0][fecha]" style="width: 8em;" readonly value="<?= $valor->fecha_soli_der ?>" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            </div><!-- fin table.responsive-->
                        </div>

                        <div class="col-md-6 form-group">
                            <h4 class="h3">Otras actividades</h4> <hr>
                            <!--<div class="float-right">
                                <a id="addrow_otras" type="button" class="btn btn-info" href="#table">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>-->
                            <div class="table-responsive">
                            <table id="tabla_otras" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Actividad&nbsp;</th>
                                    <th>Ingreso&nbsp;</th>
                                    <th>Antigüedad&nbsp;</th>
                                    <th> Empresa</th>
                                    <th><!-- Opción Remover --> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tabla_otras as $indice => $valor)  { ?>
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm "             name="text_tabla_otras[0][actividades]" style="width: 8em;" readonly value="<?= $valor->actividades_soli_o ?>">
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_otras[0][ingreso]" readonly value="<?= $valor->ingreso_soli_o ?>">
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_otras[0][antiguedad]" readonly value="<?= $valor->antiguedad_soli_o ?>" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm "             name="text_tabla_otras[0][empresa]" style="width: 6em;" readonly value="<?= $valor->empresa_soli_o ?>">
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                    </div><!-- FIN ROW -->

                        <?php if ($solicitud->foto_nombre_soli != '' && $solicitud->foto_nombre_soli != NULL) { ?>
                            <div class="row justify-content-md-center">

                                <div class="card text-center" style="width: 20em;">
                                    <h4 >Foto</h4>
                                    <img class="card-img-top img-thumbnail" src="<?=  base_url('public/img/fotos_solicitud/'). $solicitud->foto_nombre_soli; ?>" alt="Foto" width="200px" height="300px" style=" margin: 0px auto;">

                                    <div class="card-block">
                                        <a href="<?=  base_url('public/img/fotos_solicitud/'). $solicitud->foto_nombre_soli; ?>" target="_blank" class="btn btn-info" title="Mostrar" >
                                            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        </a>
                                        <?php if ( $solicitud->foto_latitud_soli != 0 && $solicitud->foto_latitud_soli != NULL  ) {  ?>
                                        <a href="http://maps.google.com/maps?q=<?= $solicitud->foto_latitud_soli ?>,<?= $solicitud->foto_longitud_soli ?>" target="_blank" class="btn btn-primary" title="Geolocalización" >
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>


                        <br> <br> <br>
                        <div class="row justify-content-center" >
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Titular</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Cónyuge Titular</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Aval</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Cónyuge Aval</h4></p>
                            </div>
                        </div>
                        <br> <br> <br><br><br>
                        <div class="row justify-content-center" >
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Asesor de Crédito Responsable</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Asesor de Crédito Nº1</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Asesor de Crédito Nº2</h4></p>
                            </div>
                            <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                                <p><h4>Gerente de Agencia</h4></p>
                            </div>
                        </div>




                  <br> <br>
                        <?php if($solicitud->id_estado_soli == 1 && ( $auth_level ==  7  || $auth_level ==  9 ) ) { ?>
                        <div class="form-group text-center">
                            <button type="submit"   class="btn btn-danger btn-lg" name="btn_verificar" id="btn_rechazar" value="3">
                                <i class="fa fa-times" aria-hidden="true"></i> RECHAZAR
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="submit"   class="btn btn-success btn-lg" name="btn_verificar" id="btn_aprobar" value="2">
                                <i class="fa fa-check" aria-hidden="true"></i> APTO
                            </button>
                            <!--<button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                            </button>-->
                        </div>
                        <?php } ?>
                    </form>
                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
        </div>
      </section>




<?php
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						  //Select2 (colegio)
                    					  'librerias/select2/dist/js/select2.js',
                    					  'recursos/solicitud/js/nueva_ficha_select2_colegios.js' ,
                    					  //popper (btn agregar colegio)
                    					  'librerias/popper/popper.min_1.12.9.js',
                    					  //validación
                    					 'assets/js/jquery.validate.min.js',
                    					 //spin
                    					 'librerias/spin/spin.min.js',
                    					 'librerias/spin/spin_variables.js',
                    					 //Sweetalert
                    					 'librerias/sweetalert/sweetalert.min.js',
                                        //datetimepicker
                                        'librerias/datetimepicker/moment.min.js',
                                        'librerias/datetimepicker/bootstrap-datetimepicker.min.js',
                                        'librerias/datetimepicker/locale/es.js',
                                        //numeric
                                        'librerias/numeric/jquery.numeric.min.js',
                                        //Calcular edad automaticamente
                                        'librerias/Calculate-Age-Birthday-Ager/ager.js',



                                        //script principal
                    					  'recursos/solicitud/js/editar_solicitud.js'
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
<?php } else if ( isset($estado_registro) &&  $estado_registro == 'registrar_error' ){ ?>
    <script>
        swal( 'Error al registrar','', "error");
    </script>
<?php } ?>
