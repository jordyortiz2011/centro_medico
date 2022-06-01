<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'Solicitud nueva',
                    'css'           => array (
                    						   //Select2
                    						   'librerias/select2/dist/css/select2.min.css',
                    						   //Sweetalert
                    					   		'librerias/sweetalert/sweetalert.css',
                                                //datetimepicker
                                                'librerias/datetimepicker/bootstrap-datetimepicker.min.css',
                                                'librerias/datetimepicker/color_dias_bloqueado.css',
                                                //Noty
                                                'librerias/noty-master/lib/noty.css',
                                                'librerias/noty-master/lib/themes/mint.css',
                                                'librerias/noty-master/lib/themes/bootstrap-v3.css',
                                                //Subida de ficheros

                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'Solicitud' => '' , 'Nueva' => '#' ),
                        'titulo'        => 'SOLICITUD DE CRÉDITO' ,
                        'titulo_icono'  => 'fa fa-file-text-o',
                        'descripcion'   => '' 
                        
                    ) ;
$this->load->view('template/d_breadcrumb.php',  $data) ; ?>  

<style>
    .form-control{
        padding: 5px 10px !important;
    }
</style>
<style>
    .thumb {
        flex: 1;
        height: 100%;
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

                </div>
                <div class="card-header d-flex align-items-center">
                 <img src="<?= base_url('public/assets/img/logo_nuevo_prisma_pequeno.jpg') ?>" width="227px"  height="51px">  &nbsp;
                 <h3>Ficha Socioeconómica - Prisma cultivo </h3>
                </div>

                  <div class="card-body">
                      <!-- IMPRIMIR ERRORES DEL FORMULARIO -->
                      <?php echo validation_errors('<div class="col-sm-12 text-center" style="margin-bottom: 1px;"><buttom class="btn btn-round btn-danger col-center">', '</buttom></div>'); ?>
                      <br>
                      <form method="POST" id="form_registrar_solicitud" action="<?= base_url('solicitud/nueva/procesa') ?>"  enctype="multipart/form-data">


                      <div class="row align-items-center">
                        <div class="col-md-4 form-group">
                               <input type="text"    required="" class="input-material" autocomplete="off" value="<?= $fecha_convertido ?>" readonly>
                               <label for="fecha_solicitud" class="label-material active" style="left: 15px;">Fecha de solicitud</label>
                           </div>
                        <div class="col-md-4 form-group">
                          <label for="select_agencias"  class="label-material active ">Agencia <span class="text-danger">*</span></label>
                          <?= $select_agencias ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="text_asesor_credito" class="label-material active" style="left: 15px;">Asesor de crédito </label>

                            <?php if ($auth_level ==  7) {?>
                                   <input type="text" name="text_asesor_credito"  id="text_asesor_credito"   class="input-material"  value="<?= $nombre_usuario ?>" readonly>

                               <?php } else {?>
                                   <?= $select_asesores ?>
                                <?php }?>
                        </div>
                      </div><!-- FIN ROW -->


                      <div class="row">
                          <div class="col-md-4 form-group">
                              <input type="text"    required="" class="input-material" autocomplete="off" value="Por definir" readonly>
                              <label for="fecha_aprobacion" class="label-material active" style="left: 15px;">Fecha de Aprobación</label>
                          </div>
                          <?php if ($auth_level ==  3) {?>
                          <div class="col-md-4 form-group">
                              <!--<label for="select_agencias"  class="label-material active ">Asesor de crédito <span class="text-danger">*</span></label>
                              <select id="select_asesores" name="select_asesores" class=' form-control' >
                                  <option>Seleccione</option>
                              </select> -->

                          </div>
                          <div class="col-md-4 form-group">
                              <input type="text" name="text_asesor_credito"  id="text_asesor_credito"   class="input-material"  value="<?= $nombre_usuario ?>" readonly>
                              <label for="text_asesor_credito" class="label-material active" style="left: 15px;">Nombre de articulador</label>
                          </div>
                          <?php }?>
                      </div><!-- FIN ROW -->

                        <br>
                        <hr>
                        <h4 class="h3">Datos Personales</h4> <hr>
                       <!-- 1era fila DEL TITULAR -->
                        <div class="row align-items-center" id="bloque_titular">
                          <div class="col-md-2  form-group row">
                              <label for="" class="col-md-12 col-form-label"> <strong>TITULAR </strong> </label>
                          </div>

                          <div class="col-md-2 form-group ">
                              <input  type="text" name="text_dni_titular" id="text_dni_titular" required="" maxlength="8" class="input-material" autocomplete="off" value="">
                              <label for="text_dni_titular" class="label-material" style="left: 15px;">DNI</label>
                          </div>

                          <div class="col-md-1  form-group  ">
                              <div class="row align-items-start">
                                  <p> &nbsp;
                                      <button type="button" id="btn_buscar_titular" class="btn btn-info" data-placement="top" data-html="true" title="Buscar titular"  >
                                          <i class="fa fa-search"></i>
                                      </button>
                                  </p>
                              </div>
                          </div>

                          <div class="col-md-2 form-group">
                              <input type="text" name="text_nombres_titular"  id="text_nombres_titular"  required="" class="input-material" autocomplete="off" value="">
                              <label for="text_nombres_titular" class="label-material" style="left: 15px;">Nombres</label>
                          </div>

                          <div class="col-md-2 form-group ">
                              <input  type="text" name="text_apellido_pat_titular" id="text_apellido_pat_titular" required="" class="input-material" autocomplete="off" value="">
                              <label for="text_apellido_pat_titular" class="label-material" style="left: 15px;">Apellido Paterno</label>
                          </div> &nbsp;&nbsp;&nbsp;&nbsp;
                          <div class="col-md-2 form-group ">
                              <input  type="text" name="text_apellido_mat_titular" id="text_apellido_mat_titular" required="" class="input-material" autocomplete="off" value="">
                              <label for="text_apellido_mat_titular" class="label-material" style="left: 15px;">Apellido Materno</label>
                          </div>
                        </div><!-- FIN ROW -->
                        <!-- fila -->
                        <div class="row row align-items-center">

                            <div class="col-md-1 form-group row">
                            </div>

                            <div class="col-md-3 form-group">
                                <input type="text" name="text_fecha_naci_titular" id="text_fecha_naci_titular"  required="" class="input-material mayor_edad" autocomplete="off" value="">
                                <label for="text_fecha_naci_titular" class="label-material" style="left: 15px;">Fecha de Naci. </label>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="text_fecha_naci_titular" class="label-material active" style="left: 15px;">Edad </label>
                                <span id="text_fecha_naci_titular_edad"></span>
                            </div>

                            <div class="col-md-2 form-group">
                                <div class="col-md-12">
                                    <label class="label-material" style="left: 15px;">Estado civil </label>
                                    <select class="form-control input-material" name="select_estado_civil" id="select_estado_civil"    data-placeholder="Estado civil" >
                                        <option></option>
                                        <!-- <option value="0"> Vacio</option>-->
                                        <option value="1"> Soltero</option>
                                        <option value="2"> Conviviente</option>
                                        <option value="3"> Viudo</option>
                                        <option value="4"> Casado</option>
                                        <option value="5"> Divorciado</option>
                                    </select>
                                    <!--<label for="text_num_hijos" class="label-material" style="left: 15px;">Estado Cívil</label>-->
                                </div>
                            </div>&nbsp;

                            <div class="col-md-3 form-group">
                                <input type="text" name="text_num_hijos" id="text_num_hijos"  required="" class="input-material" autocomplete="off" value="">
                                <label for="text_num_hijos" class="label-material" style="left: 15px;">Nº de Hijos</label>
                            </div>
                        </div><!-- FIN ROW -->
                        <br>
                        <!-- fila -->
                        <div class="row  align-items-center">
                            <div class="col-md-1 form-group row">

                            </div>
                            <div class="col-md-2 form-group">
                                <label class="label-material" style="left: 15px;">Tenencia de vivienda </label>
                                <select class="form-control " name="select_tenencia_terreno" id="select_tenencia_terreno"    data-placeholder="Seleccione" >
                                    <option></option>
                                    <!--<option value="0"> Vacio</option>-->
                                    <option value="1"> Propio</option>
                                    <option value="2"> Alquilado</option>
                                    <option value="3"> Familiar</option>
                                    <option value="4"> Ambulante</option>
                                    <option value="5"> Cedido</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="label-material" style="left: 15px;">Servicios Básicos </label>
                                <select class="form-control select2 " name="select_servicios_basicos" id="select_servicios_basicos"    data-placeholder="Seleccione" >
                                    <option></option>
                                    <!--<option value="0"> Vacio</option>-->
                                    <option value="1"> Luz, Agua, Desagüe y Teléfono </option>
                                    <option value="2">  Luz, Agua y  Desagüe</option>
                                    <option value="3"> Agua y  Desagüe</option>
                                    <option value="4"> Agua </option>
                                    <option value="5"> Ninguno</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                    <input type="text" name="text_celular_titular"  id="text_celular_titular" required="" maxlength="9" class="input-material" autocomplete="off" value="">
                                <label for="text_celular_titular" class="label-material" style="left: 15px;">Celular</label>
                            </div>

                            <div class="col-md-3 form-group row">
                                <div class="col-md-12">
                                    <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                                    <select class="form-control input-material" name="select_grado_instru_titular" id="select_grado_instru_titular"    data-placeholder="Grado de instrucción" >
                                        <option></option>
                                        <!-- <option value="0"> Vacio</option>-->
                                        <option value="1"> Superior</option>
                                        <option value="2"> Técnico</option>
                                        <option value="3"> Secundaria</option>
                                        <option value="4"> Primaria</option>
                                        <option value="5"> Sin Instrucción</option>
                                    </select>
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
                                    <select class="form-control input-material select2" name="select_departamentos" id="select_departamentos"    data-placeholder="Seleccione" >
                                        <option></option>
                                        <?php foreach ($lst_departamentos as $departamento) {?>
                                            <option value="<?= $departamento->idDepa ?>"><?= $departamento->departamento ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group row">
                                <div class="col-md-12" id="contenedor_select_provincias">
                                    <label class="label-material" style="left: 15px;">Provincia </label>
                                    <select class="form-control input-material select2" name="select_provincias" id="select_provincias"    data-placeholder="Seleccione" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group row">
                                <div class="col-md-12" id="contenedor_select_distritos">
                                    <label class="label-material" style="left: 15px;">Distrito </label>
                                    <select class="form-control input-material select2" name="select_distritos" id="select_distritos"    data-placeholder="Seleccione" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                         </div> <!-- FIN ROW -->
                        <br>
                        <!-- fila direccion -->
                        <div class="row">
                            <div class="col-md-1 form-group row">                                &nbsp;&nbsp;
                            </div>
                            <div class="col-md-5 form-group ">
                                <label for="text_direccion" class="label-material" style="left: 15px;">Dirección del domicilio</label>
                                <input type="text" name="text_direccion" id="text_direccion"  style="left: 15px;" required="" class="input-material" autocomplete="off" value="">
                            </div>
                            <div class="col-md-5 form-group ">
                                <label for="text_direccion_terreno" class="label-material" style="left: 15px;">Dirección del terreno agrícola</label>
                                <input type="text" name="text_direccion_terreno" id="text_direccion_terreno"  style="left: 15px;" required="" class="input-material" autocomplete="off" value="">
                            </div>

                        </div><!-- FIN ROW -->
                        <!-- fila  ACTIVIDAD PRINCIPAL TITULAR -->
                        <div class="row">
                            <div class="col-md-1 form-group row">
                                &nbsp;&nbsp;
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="label-material" style="left: 15px;">Actividad Principal </label>
                                <input type="text" name="text_actividad_principal_titular"  id="text_actividad_principal_titular"   class="input-material" autocomplete="off" value="">
                            </div>
                            <div class="col-md-3 form-group ">
                                    <label class="label-material" style="left: 15px;">Tenencia de local o terreno </label>
                                    <select class="form-control input-material select2" name="select_terreno_principal_titular" id="select_terreno_principal_titular"    data-placeholder="Seleccione" >
                                        <option></option>
                                        <option value="1">Propio</option>
                                        <option value="2">Alquilado</option>
                                        <option value="3">Familiar </option>
                                        <option value="4">Ambulante</option>
                                        <option value="5">Cedido</option>
                                    </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="label-material" style="left: 15px;">Area Mts o HAS </label>
                                <input type="text" name="text_area_principal_titular"  id="text_area_principal_titular"   class="input-material" autocomplete="off" value="">
                            </div>
                        </div><!-- FIN ROW -->
                        <br>

                        <!-- fila ACTIVIDAD SECUNDARIA TITULAR -->
                        <div class="row">
                            <div class="col-md-1 form-group row">
                                &nbsp;&nbsp;
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="label-material" style="left: 15px;">Actividad Secundaria  </label>
                                <input type="text" name="text_actividad_secundaria_titular"  id="text_actividad_secundaria_titular"   class="input-material" autocomplete="off" value="">
                            </div>
                            <div class="col-md-3 form-group ">
                                <label class="label-material" style="left: 15px;">Tenencia de local o terreno </label>
                                <select class="form-control input-material select2" name="select_terreno_secundaria_titular" id="select_terreno_secundaria_titular"    data-placeholder="Seleccione" >
                                    <option></option>
                                    <option value="1">Propio</option>
                                    <option value="2">Alquilado</option>
                                    <option value="3">Familiar </option>
                                    <option value="4">Ambulante</option>
                                    <option value="5">Cedido</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="label-material" style="left: 15px;">Area Mts o HAS </label>
                                <input type="text" name="text_area_secundaria_titular"  id="text_area_secundaria_titular"   class="input-material" autocomplete="off" value="">
                            </div>
                        </div><!-- FIN ROW -->

                        <!-- TITULAR - TIPO DE SOCIO -->
                        <div class="row">
                            <div class="col-md-1 form-group row">
                                &nbsp;&nbsp;
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="label-material" style="left: 15px;">Tipo de Socio </label>
                                <select class="form-control select2 " name="select_tipo_socio" id="select_tipo_socio"    data-placeholder="Seleccione" >
                                    <option></option>
                                    <!--<option value="0"> Vacio</option>-->
                                    <option value="1"> Nuevo </option>
                                    <option value="2"> Recurrente</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group" id="bloque_numero_creditos">
                                <label for="text_numero_creditos" class="label-material" style="left: 15px;">Número de créditos</label>

                                <div class="validacion">
                                    <input type="text" name="text_numero_creditos" id="text_numero_creditos"  required="" class="input-material solo_numeros" autocomplete="off" value="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- USTED VENDE SU PRODUCCIÓN A:  -->
                        <div class="row">

                            <label  class="label-material" style="left: 15px;">&nbsp;&nbsp; Ud. Vende su Producción a:</label>
                            &nbsp; &nbsp; &nbsp;
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" value="1" id="checkbox_asociacion" name="checkbox_vende_produccion[]">
                                <label class="form-check-label" for="checkbox_asociacion" style="padding-left: 0px;">Asociación </label>
                            </div>
                            <div class="col-md-2">
                                &nbsp;&nbsp;&nbsp;<input class="form-check-input" type="checkbox" value="2" id="checkbox_cooperativa" name="checkbox_vende_produccion[]">
                                <label class="form-check-label" for="checkbox_cooperativa" style="padding-left: 0px;">Cooperativa</label>
                            </div>
                            <div class="col-md-2">
                                &nbsp;&nbsp;&nbsp;<input class="form-check-input" type="checkbox" value="3" id="checkbox_comite" name="checkbox_vende_produccion[]">
                                <label class="form-check-label" for="checkbox_comite" style="padding-left: 0px;">Comité Productor </label>
                            </div>
                            <div class="col-md-2">
                                &nbsp;&nbsp;&nbsp;<input class="form-check-input" type="checkbox" value="4" id="checkbox_intermediario" name="checkbox_vende_produccion[]">
                                <label class="form-check-label" for="checkbox_intermediario" style="padding-left: 0px;">Intermediario </label>
                            </div>

                            <br><span style="margin-left: 20px" id="error_checkbox_vende_produccion"> </span>
                        </div>

                        <br><br>
                        <!-- Fila DEL CONYUGUE -->
                        <div class="row  align-items-center row_datos_conyuge d-none">
                            <div class="col-md-2  form-group row">
                                <label for="" class="col-md-12 col-form-label"> &nbsp; <strong>CÓNYUGE </strong> </label>
                            </div>

                            <div class="col-md-2 form-group ">
                                <input type="text"  id="text_dni_conyugue" name="text_dni_conyugue"  maxlength="8" class="input-material" autocomplete="off" value="">
                                <label for="text_dni_conyugue" class="label-material" style="left: 15px;">DNI</label>
                            </div>&nbsp;&nbsp;&nbsp;

                            <div class="col-md-1  form-group row">
                                <p> &nbsp;
                                    <button type="button" id="btn_buscar_conyuge" class="btn btn-info" data-placement="top" data-html="true" title="Buscar conyuge"  >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </p>
                            </div>

                            <div class="col-md-2 form-group">
                                <input id="text_nombres_conyugue"  type="text" name="text_nombres_conyugue" class="input-material" autocomplete="off" value="">
                                <label for="text_nombres_conyugue" class="label-material" style="left: 15px;">Nombres</label>
                            </div>
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_pat_conyugue" type="text" name="text_apellido_pat_conyugue"  class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_pat_conyugue" class="label-material" style="left: 15px;">Apellido Paterno</label>
                            </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_mat_conyugue" type="text" name="text_apellido_mat_conyugue" class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_mat_conyugue" class="label-material" style="left: 15px;">Apellido Materno</label>
                            </div>
                        </div><!-- FIN 1ra Fila Conyugue -->

                        <!-- fila -->
                        <div class="row align-items-center row_datos_conyuge d-none">
                            <div class="col-md-1 form-group row">
                                &nbsp;
                            </div>
                            <div class="col-md-3 form-group row">
                                <div class="col-md-12">
                                    <label class="label-material" style="left: 15px;">Grado de instrucción </label>
                                    <select class="form-control input-material" name="select_grado_instru_conyugue" id="select_grado_instru_conyugue"    data-placeholder="Grado de instrucción" >
                                        <option></option>
                                        <option value="1"> Superior</option>
                                        <option value="2"> Técnico</option>
                                        <option value="3"> Secundaria</option>
                                        <option value="4"> Primaria</option>
                                        <option value="5"> Sin Instrucción</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" name="text_fecha_naci_conyugue" id="text_fecha_naci_conyugue"   class="input-material mayor_edad" autocomplete="off" value="">
                                <label for="text_fecha_naci_conyugue" class="label-material" style="left: 15px;">Fecha de Nacimiento</label>
                            </div>
                            <div class="col-md-1 form-group">
                                <label for="text_fecha_naci_conyugue_edad" class="label-material active" style="left: 15px;">Edad </label>
                                <span id="text_fecha_naci_conyugue_edad"></span>
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" name="text_celular_conyugue"  id="text_celular_conyugue"  maxlength="9" class="input-material" autocomplete="off"  value="">
                                <label for="text_celular_conyugue" class="label-material" style="left: 15px;">Celular</label>
                            </div>

                        <br>
                        </div><!-- FIN ROW -->
                         <hr>

                          <!-- fila comprobación de posee  AVAL -->
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group row">
                                      <label class="col-md-4 form-control-label">¿Posee Aval?</label>
                                      <input type="checkbox" name="checkbox_posee_aval" id="checkbox_posee_aval">
                                  </div>
                              </div>
                          </div>
                        <!-- fila DEL AVAL -->
                        <div class="row row_datos_aval d-none">
                            <div class="col-md-2  form-group row">
                                <label for="staticEmail" class="col-md-12 col-form-label"> <strong> &nbsp; AVAL </strong> </label>
                            </div>

                            <div class="col-md-2 form-group">
                                <input id="text_nombres_aval" type="text" name="text_nombres_aval" class="input-material"  autocomplete="off" value="">
                                <label for="text_nombres_aval" class="label-material" style="left: 15px;">Nombres</label>
                            </div>
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_pat_aval" type="text" name="text_apellido_pat_aval"  class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_pat_aval" class="label-material" style="left: 15px;">Apellido Paterno</label>
                            </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_mat_aval" type="text" name="text_apellido_mat_aval" class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_mat_aval" class="label-material" style="left: 15px;">Apellido Materno</label>
                            </div>
                            <div class="col-md-2 form-group ">
                                <input id="text_dni_aval" type="text" name="text_dni_aval"  maxlength="8" class="input-material" autocomplete="off" value="">
                                <label for="text_dni_aval" class="label-material" style="left: 15px;">DNI</label>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <br>
                        </div><!-- FIN ROW -->


                        <!-- fila -->
                        <div class="row row_datos_aval d-none">
                            <div class="col-md-1 form-group row"> &nbsp;
                            </div>

                            <div class="col-md-2 form-group ">
                                <input type="text" name="text_direccion_aval" id="text_direccion_aval"  style="left: 15px;" class="input-material" autocomplete="off" value="">
                                <label for="text_direccion_aval" class="label-material" style="left: 15px;">Dirección del domicilio</label>
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" name="text_fecha_naci_aval" id="text_fecha_naci_aval"   class="input-material" autocomplete="off" value="">
                                <label for="text_fecha_naci_aval" class="label-material" style="left: 15px;">Fecha de Nacimiento</label>
                            </div>

                            <div class="col-md-1 form-group">
                                <label for="text_fecha_naci_aval_edad" class="label-material active" style="left: 15px;">Edad </label>
                                <span id="text_fecha_naci_aval_edad"></span>
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" name="text_celular_aval"  id="text_celular_aval"  maxlength="9" class="input-material" autocomplete="off"  value="">
                                <label for="text_celular" class="label-material" style="left: 15px;">Celular</label>
                            </div>
                        <br>
                        </div><!-- FIN ROW -->



                        <!-- fila DEL CÓNYUGUE DEL AVAL -->
                        <div class="row row_datos_aval_conyuge d-none">
                            <div class="col-md-2  form-group row">
                                <label for="staticEmail" class="col-md-12 col-form-label">  &nbsp; <strong> CÓNYUGUE  &nbsp;DEL AVAL </strong> </label>
                            </div>

                            <div class="col-md-2 form-group">
                                <input id="text_nombres_conyu_aval" type="text" name="text_nombres_conyu_aval" class="input-material" autocomplete="off" value="">
                                <label for="text_nombres_conyu_aval" class="label-material" style="left: 15px;">Nombres</label>
                            </div>
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_pat_conyu_aval" type="text" name="text_apellido_pat_conyu_aval"  class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_pat_conyu_aval" class="label-material" style="left: 15px;">Apellido Paterno</label>
                            </div>						  &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-md-2 form-group ">
                                <input id="text_apellido_mat_conyu_aval" type="text" name="text_apellido_mat_conyu_aval" class="input-material" autocomplete="off" value="">
                                <label for="text_apellido_mat_conyu_aval" class="label-material" style="left: 15px;">Apellido Materno</label>
                            </div>
                            <div class="col-md-2 form-group ">
                                <input id="text_dni_conyu_aval" type="text" name="text_dni_conyu_aval"  maxlength="8" class="input-material" autocomplete="off" value="">
                                <label for="text_dni_conyu_aval" class="label-material" style="left: 15px;">DNI</label>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <br>
                        </div><!-- FIN ROW -->


                        <!-- fila -->
                        <div class="row row_datos_aval_conyuge d-none">
                            <div class="col-md-1 form-group row">
                                &nbsp;
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="text_fecha_naci_conyu_aval" id="text_fecha_naci_conyu_aval"   class="input-material" autocomplete="off" value="">
                                <label for="text_fecha_naci_conyu_aval" class="label-material" style="left: 15px;">Fecha de Nacimiento</label>
                            </div>

                            <div class="col-md-4 form-group">
                                <input type="text" name="text_celular_conyu_aval"  id="text_celular_conyu_aval"  maxlength="9"  class="input-material" autocomplete="off"  value="">
                                <label for="text_celular" class="label-material" style="left: 15px;">Celular</label>
                            </div>

                        </div><!-- FIN ROW -->


                    <div class="row">
                        <div class="col"><hr></div>
                    </div>
                    <h4 class="h3" >&nbsp; Deuda sistema financiero </h4>
                   <!-- Deuda sistema financiero titular -->
                   <b>&nbsp;&nbsp;&nbsp;<u>Títular: </u></b> <hr>
                   <div class="row">

                       <div class="col-md-4">
                           <div class="form-group row">
                               <div class="col-md-1">
                               </div>
                               <label class="col-md-6 form-control-label"> ¿Registra DUD, DEF o PER en los últimos 24 meses?</label>
                               <div class="col-md-4">
                                   <div class="input-group">
                                       <select   name="select_registra_deuda_titular" id="select_registra_deuda_titular" data-placeholder="Seleccione"    >
                                           <option></option>
                                           <option value="SI" >SI</option>
                                           <option value="NO">NO</option>
                                       </select>
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
                                       <input type="text" class="form-control" id="text_impagos_titular" name="text_impagos_titular"  >
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
                                       <input type="text" class="form-control"  id="text_protestos_titular" name="text_protestos_titular">
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="col-md-12 form-group ">
                           <div class="float-right">
                               <a id="addrow_deuda_titular" type="button" class="btn btn-info"  href="#/" >
                                   <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                               </a>
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
                                       <th>Monto de la cuota (S/) </th>
                                       <th>Cuotas pendientes</th>
                                       <th><!-- Opción Remover --> </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr>
                                       <td>
                                           <div><input type="text"  name="text_tabla_deuda_titular[0][entidad]"  class="form-control form-control-sm solo_mayusculas" autocomplete="off"  style="width: 15em;" > </div>
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][fecha_consulta]"  class="form-control form-control-sm  solo_fechas_nuevo" autocomplete="off"  style="width: 8em;" >
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][saldo_deuda_consulta]"  class="form-control form-control-sm solo_numeros" autocomplete="off" style="width: 8em;" >
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][ultima_calificacion]"  class="form-control form-control-sm solo_mayusculas" autocomplete="off"  style="width: 5em;" >
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][peor_calificacion]"  class="form-control form-control-sm solo_mayusculas"  autocomplete="off" style="width: 5em;" >
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][saldo_deuda_evaluacion]"  class="form-control form-control-sm solo_numeros" autocomplete="off"  style="width: 10em;">
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][cuota_pendiente]"  class="form-control form-control-sm solo_numeros" autocomplete="off" style="width: 10em;"  >
                                       </td>
                                       <td>
                                           <input type="text" name="text_tabla_deuda_titular[0][num_cuotas_pendiente]"  class="form-control form-control-sm solo_numeros"  autocomplete="off" style="width: 5em;"  >
                                       </td>
                                       <td>
                                           <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                               <i class='fa fa-trash-o bigger-150'></i>
                                           </a>-->
                                       </td>
                                   </tr>
                               </tbody>
                               <tfoot>
                                   <tr>
                                       <td colspan="2" class="text-center"> <b>TOTAL</b>  </td>
                                       <td class="text-center">
                                           <h5 id="sumatoria_deuda_consulta_titular"> 0</h5>
                                       </td>
                                       <td> &nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td class="text-center">
                                           <h5 id="sumatoria_deuda_evaluacion_titular"> 0</h5>
                                       </td>
                                       <td class="text-center">
                                           <h5 id="sumatoria_cuota_pendiente_titular"> 0</h5>
                                       </td>
                                   </tr>
                               </tfoot>
                           </table>
                           </div><!-- fin table responsive -->
                       </div>
                   </div><!-- FIN ROW -->

                    <!-- Deuda sistema financiero conyuge -->
                          <div class="row_datos_conyuge d-none">
                                <b><u>Cónyuge: </u></b> <hr>
                               <div class="row">

                                   <div class="col-md-4">
                                       <div class="form-group row">
                                           <div class="col-md-1" ></div>
                                           <label class="col-md-6 ">¿Registra DUD, DEF o PER en los últimos 24 meses?</label>
                                           <div class="col-md-4">
                                               <div class="input-group">
                                                   <select   name="select_registra_deuda_titular" id="select_registra_deuda_conyuge" data-placeholder="Seleccione"    >
                                                       <option></option>
                                                       <option value="SI" >SI</option>
                                                       <option value="NO">NO</option>
                                                   </select>
                                                   <input type="hidden" name="hidden_registra_deuda_conyuge" id="hidden_registra_deuda_conyuge">
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
                                                   <input type="text" class="form-control" id="text_impagos_conyuge" name="text_impagos_conyuge" >
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
                                                   <input type="text" class="form-control"   id="text_protestos_conyuge" name="text_protestos_conyuge">
                                               </div>
                                           </div>
                                       </div>
                                   </div>


                                   <div class="col-md-12 form-group ">
                                       <div class="float-right">
                                           <a id="addrow_deuda_conyuge" type="button" class="btn btn-info"  href="#/" >
                                               <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                           </a>
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
                                                   <th>Cuota Pendiente (S/) </th>
                                                   <th>Cuotas pendientes</th>
                                                   <th><!-- Opción Remover --> </th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               <tr>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][entidad]"   class="form-control form-control-sm " autocomplete="off" style="width: 15em;" >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][fecha_consulta]"  class="form-control form-control-sm " autocomplete="off"  style="width: 8em;" >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][saldo_deuda_consulta]"  class="form-control form-control-sm solo_numeros" autocomplete="off" style="width: 8em;" >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][ultima_calificacion]"  class="form-control form-control-sm " autocomplete="off"  style="width: 5em;" >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][peor_calificacion]"  class="form-control form-control-sm "  autocomplete="off" style="width: 5em;" >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][saldo_deuda_evaluacion]"  class="form-control form-control-sm solo_numeros" autocomplete="off"  style="width: 10em;">
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][cuota_pendiente]"  class="form-control form-control-sm solo_numeros" autocomplete="off" style="width: 10em;"  >
                                                   </td>
                                                   <td>
                                                       <input type="text" name="text_tabla_deuda_conyuge[0][num_cuotas_pendiente]"  class="form-control form-control-sm solo_numeros"  autocomplete="off" style="width: 5em;"  >
                                                   </td>
                                                   <td>
                                                       <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                                           <i class='fa fa-trash-o bigger-150'></i>
                                                       </a>-->
                                                   </td>
                                               </tr>
                                               </tbody>
                                               <tfoot>
                                               <tr>
                                                   <td colspan="2" class="text-center"> <b>TOTAL</b>  </td>
                                                   <td class="text-center">
                                                       <h5 id="sumatoria_deuda_consulta_conyuge"> 0</h5>
                                                   </td>
                                                   <td> &nbsp;</td>
                                                   <td>&nbsp;</td>
                                                   <td class="text-center">
                                                       <h5 id="sumatoria_deuda_evaluacion_conyuge"> 0</h5>
                                                   </td>
                                                   <td class="text-center">
                                                       <h5 id="sumatoria_cuota_pendiente_conyuge"> 0</h5>
                                                   </td>
                                               </tr>
                                               </tfoot>
                                           </table>
                                       </div><!-- fin table responsive -->
                                   </div>
                               </div><!-- FIN ROW -->
                          </div> <!-- Fin contenedor deuda sistema financiero conyuge -->

                    <br><br>
                    <h4 class="h3">Diversificación de cultivo </h4> <hr>
                    <!-- Deuda sistema financiero -->
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="float-right">
                                <a id="addrow_cultivo" type="button" class="btn btn-info" href="#/">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>
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
                                <tr>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][cultivo]"  class="form-control form-control-sm " autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][unidad]"  class="form-control form-control-sm " autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][mes]"  class="form-control form-control-sm solo_fechas_mes" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][ha_totales]"  class="form-control form-control-sm solo_numeros" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][ha_produccion]"  class="form-control form-control-sm solo_numeros" autocomplete="off" >
                                    </td>

                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][produccion]"  class="form-control form-control-sm solo_numeros" autocomplete="off" >
                                    </td>

                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][precio]"  class="form-control form-control-sm solo_numeros" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" name="text_tabla_cultivo[0][total]"  class="form-control form-control-sm solo_numeros" autocomplete="off" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-center"> <b>TOTAL</b>  </td>
                                        <td class="text-center">
                                            <h4 id="total_sumatoria_cultivo"> 0</h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div><!-- fin div.table_responsive-->
                        </div>
                    </div><!-- FIN ROW -->


                    <br>
                    <h4 class="h3">Diversificación Pecuaria </h4> <hr>
                    <!-- Deuda sistema financiero -->
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="float-right">
                                <a id="addrow_pecuaria" type="button" class="btn btn-info" href="#tabla_pecuaria">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>
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
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_pecuaria[0][nombre]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][num_animales]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][autoconsumo]"  autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][num_animales_venta]" style="width: 5em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_fechas" name="text_tabla_pecuaria[0][fecha_venta]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros" name="text_tabla_pecuaria[0][precio]" autocomplete="off"  >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm solo_numeros"  name="text_tabla_pecuaria[0][total]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>

                                </tr>

                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div><!-- FIN ROW -->

                    <!-- tabla derivados -->
                    <div class="row d-none">
                        <div class="col-md-6 form-group">
                            <h4 class="h3">Diversificación derivados </h4> <hr>
                            <div class="float-right">
                                <a id="addrow_derivados" type="button" class="btn btn-info" href="#tabla_derivados">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>
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
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_derivados[0][derivados]" style="width: 8em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm " name="text_tabla_derivados[0][unidad]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_derivados[0][produccion]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_derivados[0][precio]" style="width: 6em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_fechas" name="text_tabla_derivados[0][fecha]" style="width: 8em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div><!-- fin table.responsive-->
                        </div>

                        <div class="col-md-6 form-group">
                            <h4 class="h3">Otras actividades</h4> <hr>
                            <div class="float-right">
                                <a id="addrow_otras" type="button" class="btn btn-info" href="#table">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                </a>
                            </div>
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
                                <tr>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm "             name="text_tabla_otras[0][actividades]" style="width: 8em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_otras[0][ingreso]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm solo_numeros" name="text_tabla_otras[0][antiguedad]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text"  class="form-control form-control-sm "             name="text_tabla_otras[0][empresa]" style="width: 6em;" autocomplete="off" >
                                    </td>
                                    <td>
                                        <!--<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>
                                            <i class='fa fa-trash-o bigger-150'></i>
                                        </a>-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>

                    </div><!-- FIN ROW -->

                      <?php if($auth_level == 3)  { ?>

                        <?php } ?>

                  <?php if($auth_level == 3)  { ?>
                      <div class="row justify-content-md-center">

                          <div class="card text-center" style="width: 20em;">
                              <h4 >Foto</h4>

                              <div  id="image-holder" style="margin: 0px auto; width: 200px; height: 200px;justify-content: center; display: flex;  flex-direction: row;" >
                                  <img class="card-img-top img-thumbnail" src="<?= base_url('public/img/fotos_solicitud/solicitud_defecto_icono.png') ?>" alt="Foto" width="200px" height="300px" style=" margin: 0px auto;">
                              </div>

                              <input type="file" name="archivo" id="archivo" style="display: inline-block; color: transparent;"  class="btn btn-default" />

                              <div id="bloque_barraProgreso_foto" class="row d-none">
                                  <div class="col-md-7 " style="display: inline-block;    " >
                                      <progress id="barra_de_progreso" value="0" max="100" style="width: 16em; margin-left: 1em;"  ></progress>
                                  </div>
                              </div>
                              <div class="card-block">
                                  <a id="boton_subir_imagen" class="btn btn-info" title="Subir foto" >
                                      <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                  </a>
                              </div>
                              <div class="card-footer">
                                  <div id="bloque_respuesta_foto" class="alert  alert-dismissible fade show" role="alert">
                                      <span id="mensaje_respuesta_foto"></span>
                                  </div>
                              </div>
                          </div>

                      </div>
                 <?php } ?>

                <div class="row">
                    <div class="col"><br><br><br></div>
                </div>

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
                        <br> <br> <br><br><br><br>
                <div class="row justify-content-center" >
                    <div class="col-md-2 text-center" style=" border-top: 3px solid black; margin-left: 1em;">
                        <p><h4>Asesor de Crédito Responsable </h4></p>
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
                    <div class="form-group text-right">
                        <button type="submit"   class="btn btn-outline-primary" name="btn_subir" value="permanecer">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br>Permanecer
                        </button>
                        <button type="submit" class="btn btn-outline-primary" name="btn_subir" value="listar">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y <br> Listar
                        </button>
                    </div>
                    </form>

                </div> <!-- FIN CARD BODY -->
              </div>
            </div>
         	
         	
         	
          </div><!--fin de fila-->
            </div>
        </div>


      </section>


<script>
    var FECHA_18_MENOS = '<?= $hoy_menos_18_anos ?>';
</script>

<?php
$version = @config_item(version_archivos);
    //ruta por defecto es public/
 $data = array (
                'javascripts' => array (
                						  //Select2
                    					  'librerias/select2/dist/js/select2.js',
                    					  //popper (btn agregar colegio)
                    					  //'librerias/popper/popper.min_1.12.9.js',
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
                                        //Combobox zonas (Departamentos, provincias, distritos)
                                        'recursos/solicitud/js/nueva_solicitud_combobox_zonas.js?'.$version,
                                        //Noty
                                        'librerias/noty-master/lib/noty.js',


                                        //script principal
                    					  'recursos/solicitud/js/nueva_solicitud.js?4.'.$version,
                                          'recursos/solicitud/js/nueva_solicitud_autocalcular.js?4.'.$version ,
                                          'recursos/solicitud/js/nueva_solicitud_webservice.js?4.'.$version,

                                        //Subida de ficheros
                                        'recursos/solicitud/js/upload.js',
                                        'recursos/solicitud/js/subida_ficheros.js',
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
