<!-- 1 ==========     CABECERA Y NAVEGACIÓN    ============= -->
<?php
    //ruta por defecto es public/
     $data = array (
                    'titulo_header' => 'FUA nueva',
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
                                                //dataTables
                                              //'librerias/datatable/datatables.min.css'  , 
                                              'librerias/datatable/bootstrap/dataTables.bootstrap.css' ,                                 
                                               'librerias/sweetalert/sweetalert.css' ,

                    						  
                                                                                                            
                                             )
                   );

    $this->load->view('template/a_head' , $data);
    $this->load->view('template/b_navbar_top');
    $this->load->view('template/c_navbar_side');
?>

 
 
<!-- lista de Título y  Navegación     -->
<?php  $data = array (  
                        'navegacion'    => array ('Principal'  => '' , 'FUA' => '' , 'Nueva' => '#' ),
                        'titulo'        => 'FORMATO ÚNICO DE ATENCIÓN - FUA' ,
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
        <div class="container-fluid card-header">
          <div class="card-header d-flex align-items-center">
                 <img src="<?= base_url('public/assets/img/logo_nuevo_sis_pequeno.jpg') ?>" width="227px"  height="51px">  &nbsp;
                 <h3>Seguro Integral de Salud </h3>
          </div>
          <div class="row col-md-12"  >


                  <div class="tabbable">
                                            <ul class="nav nav-tabs padding-18">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#home">
                                                        <i></i>
                                                       Fua adelante
                                                    </a>
                                                </li>

                                                <li>
                                                    <a data-toggle="tab" href="#feed">
                                                        <i ></i>
                                                       fua atras
                                                    </a>
                                                </li>

                                            </ul>

                                            <div class="tab-content no-border padding-24">
                                                <div id="home" class="tab-pane in active">
                                                    <div class="row">
                                                      
                                                        <div class="col-xs-12 col-sm-9">
                                                           

                                                            <div class="profile-user-info">
                                                                <table class="table table-bordered " >
                          <tr style="background-color: #B0BED9" class="text-center">
                              <td colspan="14"> FORMATO ÚNICO DE ATENCIÓN - FUA </td>
                          </tr>

                          <tr class="text-center">
                              <td rowspan="3"> </td>
                              <td colspan="3" style="background-color: #d0d0d0d0"> NÚMERO DE FORMATO </td>
                              <td colspan="6" style="background-color: #d0d0d0d0"> INSTITUCIÓN EDUCATIVA  </td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> CÓDIGO  </td>
                          </tr>

                          <tr class="text-center">
                              <td rowspan="2" > 240 </td>
                              <td rowspan="2"> 20 </td>
                              <td rowspan="2"> 0075911 </td>
                              <td colspan="6">   </td>
                              <td colspan="2"> </td>
                           
                          </tr>

                           <tr class="text-center">
                            
                              <td style="background-color: #d0d0d0d0"> INI </td>
                              <td style="background-color: #d0d0d0d0"> PRI </td>
                              <td style="background-color: #d0d0d0d0"> SEC </td>
                              <td> </td>
                              <td style="background-color: #d0d0d0d0"> SECCIÓN </td>
                              <td> </td>
                              <td style="background-color: #d0d0d0d0"> TURNO </td>
                              <td> </td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="12"style="background-color: #d0d0d0d0"> DE LA INSTITUCIÓN PRESTADORA DE SERVICIOS DE SALUD </td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="3"style="background-color: #d0d0d0d0"> CÓDIGO RENAES DE LA IPRESS   </td>
                              <td colspan="9"style="background-color: #d0d0d0d0"> NOMBRE DE LA IPRESS QUE REALIZA LA ATENCIÓN   </td>
                          </tr>
                           <tr class="text-center">
                              <td colspan="3">  </td>
                              <td colspan="9"> </td>
                          </tr>
                    
                      </table>   

                      <table class="table table-bordered " style=" display: block; overflow-x: auto;">
                          <tr class="text-center">
                              <td colspan="3"> PERSONAL QUE ATIENDE</td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> LUGAR DE ATENCIÓN</td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> ATENCIÓN </td>
                              <td colspan="3" style="background-color: #d0d0d0d0"> REFERENCIA REALIZADA POR</td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="1"> DE LA IPRESS</td>
                              <td colspan="1"> </td>
                              <td colspan="1">CÓDIGO DE LA OFERTA FLEXIBLE</td>
                              <td colspan="1" style="background-color: #d0d0d0d0"> INTRAMURAL</td>
                              <td colspan="1"> </td>
                              <td style="background-color: #d0d0d0d0">AMBULATORIA </td>
                              <td > </td>
                              <td style="background-color: #d0d0d0d0">CÓD RENAES</td>
                              <td style="background-color: #d0d0d0d0">NOMBRE DE LA IPRESS U OFERTA FLEXIBLE</td>
                              <td style="background-color: #d0d0d0d0">N° HOJA DE REFERENCIA </td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="1"> ITINERANTE</td>
                              <td colspan="1"> </td>
                              <td rowspan="4"> </td>
                              <td style="background-color: #d0d0d0d0">EXTRAMURAL</td>
                              <td > </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> REFERENCIA </td>
                              <td rowspan="2"> </td>
                              <td rowspan="4"> </td>
                              <td rowspan="4"> </td>
                              <td rowspan="4"> </td>
                          </tr>

                          <tr class="text-center">
                              <td colspan="1"> PLAN MAS SALUD</td>
                              <td colspan="1"> </td>
                              <td rowspan="3" colspan="2"></td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="1"> OFERTA FLEXIBLE</td>
                              <td colspan="1"> </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> EMERGENCIA</td>
                              <td rowspan="2"> </td>
                          </tr>

                          <tr class="text-center">
                              <td colspan="1"> TELESALUD</td>
                              <td colspan="1"> </td>
                             
                          </tr>
                      </table>     


              <table class="table table-bordered " >
                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="7"> DEL ASEGURADO/USUARIO </td>
                          </tr>

                          <tr class="text-center">
                              <td colspan="2" style="background-color: #d0d0d0d0"> IDENTIFICACIÓN </td>
                              <td colspan="3" style="background-color: #d0d0d0d0"> CÓDIGO DEL ASEGURADO SIS  </td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> ASEGURADO DE OTRA IAFAS  </td>
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0"> TDI </td>
                              <td style="background-color: #d0d0d0d0"> N° DOCUMENTO DE IDENTIDAD </td>
                              <td style="background-color: #d0d0d0d0">DIRESA/OTROS </td>
                              <td style="background-color: #d0d0d0d0" colspan="2"> NÚMERO   </td>
                              <td style="background-color: #d0d0d0d0"> INSTITUCIÓN </td>
                              <td ></td>
                          </tr>

                           <tr class="text-center">
                            
                              <td >  </td>
                              <td >  </td>
                              <td > 240 </td>
                              <td> </td>
                              <td >  </td>
                              <td style="background-color: #d0d0d0d0"> COD. SEGURO</td>
                              <td>  </td>
                              
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="3"> APELLIDO PATERNO  </td>
                              <td style="background-color: #d0d0d0d0" colspan="4"> APELLIDO MATERNO </td>
                          </tr>

                          <tr class="text-center">
                              <td colspan="3">  </td>
                              <td colspan="4">  </td>
                          </tr>


                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="3"> PRIMER NOMBRE  </td>
                              <td style="background-color: #d0d0d0d0" colspan="4"> OTROS NOMBRES </td>
                          </tr>
                          
                          <tr class="text-center">
                              <td colspan="3">  </td>
                              <td colspan="4">  </td>
                          </tr>

                      </table>  

                      <table class="table table-bordered " style=" display: block; overflow-x: auto;">

                       <tr class="text-center">
                              <td colspan="2" style="background-color: #d0d0d0d0"> SEXO </td>
                              <td style="background-color: #d0d0d0d0"> FECHA </td>
                              <td style="background-color: #d0d0d0d0"> DÍA </td>
                              <td style="background-color: #d0d0d0d0"> MES </td>
                              <td colspan="4" style="background-color: #d0d0d0d0"> AÑO  </td>
                              <td style="background-color: #d0d0d0d0"> N° DE HISTORIA CLÍNICA</td>
                              <td style="background-color: #d0d0d0d0"> ETNIA </td>
                              
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0"> MASCULINO </td>
                              <td >  </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> FICHA PROBABALE DE PARTO/ FECHA DE PARTO </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              <td rowspan="2">  </td>
                              
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0"> FEMENINO </td>
                              <td >  </td>                             
                          </tr>

                          <tr class="text-center">
                              <td colspan="2" style="background-color: #d0d0d0d0"> SALUD MATERNA </td>
                              <td colspan="1.5" style="background-color: #d0d0d0d0"> FECHA DE NACIMIENTO </td>   
                              <td> </td> 
                              <td> </td>
                              <td> </td> 
                              <td> </td> 
                              <td> </td> 
                              <td> </td>
                              <td style="background-color: #d0d0d0d0"> DNI/CNV/AFILIACIÓN DEL RN 1 </td>
                              <td>  </td>                           
                          </tr>

                          <tr class="text-center">
                              <td rowspan="1" style="background-color: #d0d0d0d0"> GESTANTE </td>
                              <td > </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> FECHA DE FALLECIMIENTO </td>   
                              <td rowspan="2"> </td> 
                              <td rowspan="2"> </td>
                              <td rowspan="2"> </td> 
                              <td rowspan="2"> </td> 
                              <td rowspan="2"> </td> 
                              <td rowspan="2"> </td>
                              <td style="background-color: #d0d0d0d0"> DNI/CNV/AFILIACIÓN DEL RN 2 </td>
                              <td>  </td>                           
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0"> PUERPERA </td>
                              <td>  </td>
                              <td style="background-color: #d0d0d0d0"> DNI/CNV/AFILIACIÓN DEL RN 3 </td>
                              <td>  </td>                           
                          </tr>


                      </table> 
                        

  
                        <table class="table table-bordered " style=" display: block; overflow-x: auto;">
                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="17"> DE LA ATENCIÓN</td>
                          </tr>

                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="3"> FICHA DE ATENCIÓN</td>
                              <td rowspan="2"> HORA</td>
                              <td rowspan="2"> UPS</td>
                              <td rowspan="2"> CÓDIGO PRESTACIONAL</td>
                              <td rowspan="2"> CÓDIGO PRESTACION(ES) ADICIONAL(ES)</td>
                              <td colspan="1" rowspan="4" style="padding-left: 100px;  transform: rotate(-90deg);" > HOSPITALIZACIÓN</td>
                              <td style="background-color: #d0d0d0d0">FECHA</td>
                              <td colspan="2" style="background-color: #d0d0d0d0">DÍA</td>
                              <td colspan="2" style="background-color: #d0d0d0d0">MES</td>
                              <td colspan="4" style="background-color: #d0d0d0d0">AÑO</td>


                          </tr>

                           <tr  class="text-center">
                              <td style="background-color: #d0d0d0d0">DÍA</td>
                              <td style="background-color: #d0d0d0d0">MES</td>
                              <td style="background-color: #d0d0d0d0">AÑO</td>
                              <td style="background-color: #d0d0d0d0">DE INGRESO</td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                          </tr>

                           <tr  class="text-center">
                              <td> </td>
                              <td> </td>
                              <td>20__</td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td style="background-color: #d0d0d0d0"> DE ALTA </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                          </tr>

                           <tr  class="text-center">
                              <td rowspan="2" colspan="2" style="background-color: #d0d0d0d0"> REPORTE VINCULADO </td>
                              <td colspan="3" style="background-color: #d0d0d0d0"> CÓD AUTORIZACIÓN</td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> N° FUA A VINCULAR </td>
                              <td style="background-color: #d0d0d0d0"> DE CORTE ADMINISTRATIVO </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                              <td> </td>
                          </tr>

                           <tr  class="text-center">
                              <td colspan="3"> </td>
                              <td colspan="2"> </td>
                            
                          </tr>
                      </table>

                      <table class="table table-bordered " style=" display: block; overflow-x: auto;">

                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="14"> CONCEPTO PRESTACIONAL </td>
                          </tr>

                           <tr  class="text-center">
                              <td rowspan="3" style="background-color: #d0d0d0d0"> ATENCIÓN DIRECTA </td>
                              <td rowspan="3"> </td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> COB EXTRAORDINARIA </td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> CARTA DE GARANTÍA </td>
                              <td rowspan="3" style="background-color: #d0d0d0d0"> TRASLADO </td>
                              <td rowspan="3"> </td>
                              <td colspan="6" style="background-color: #d0d0d0d0"> SEPELIO </td>
                            
                          </tr>

                           <tr  class="text-center" >
                              <td style="background-color: #d0d0d0d0"> N° ATORIZACIÓN</td>
                              <td ></td>
                              <td style="background-color: #d0d0d0d0"> N° ATORIZACIÓN</td>
                              <td ></td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> NATIMUERTO</td>
                              <td rowspan="2"> </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> OBITO</td>
                              <td rowspan="2"> </td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> OTRO</td>
                              <td rowspan="2"> </td>
                            
                          </tr>

                           <tr  class="text-center" >
                              <td style="background-color: #d0d0d0d0"> MONTO S/</td>
                              <td ></td>
                              <td style="background-color: #d0d0d0d0"> MONTO S/</td>
                              <td ></td>
                            
                          </tr>

                      </table>

                      <table class="table table-bordered " style=" display: block; overflow-x: auto;">

                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="18">DEL DESTINO DEL ASEGURADOR </td>
                          </tr>
                          <tr class="text-center">
                              <td rowspan="2" style="background-color: #d0d0d0d0"> ALTA</td>
                              <td rowspan="2"></td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> CITA</td>
                              <td rowspan="2"></td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> HOSPITALIZACIÓN</td>
                              <td rowspan="2"></td>
                              <td colspan="6" style="background-color: #d0d0d0d0"> REFERIDO</td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> CONTRAREFERIDO</td>
                              <td rowspan="2"></td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> FALLECIDO</td>
                              <td rowspan="2"></td>
                              <td rowspan="2" style="background-color: #d0d0d0d0"> CORTE ADMINISTRATIVO</td>
                              <td rowspan="2"></td>
                          </tr>

                          <tr class="text-center">
                               <td style="background-color: #d0d0d0d0"> EMERGENCIA</td>
                               <td ></td>
                               <td style="background-color: #d0d0d0d0"> CONSULTA EXTERNA</td>
                               <td ></td>
                               <td style="background-color: #d0d0d0d0"> APOYO AL DIAGNOSTICO</td>
                               <td ></td>
                          </tr>

                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="18"> SE REFIERE/CONTRAREFIERE A: </td>
                          </tr>
                          <tr  class="text-center">
                              <td colspan="5" style="background-color: #d0d0d0d0">CÓDIGO RENAES DE LA IPRESS </td>
                              <td colspan="8" style="background-color: #d0d0d0d0">NOMBRE DE LA IPRESS A LA QUE SE REFIERE/CONTRAREFIERE </td>
                              <td colspan="5" style="background-color: #d0d0d0d0">N° HOJA DE REFER/CONTRAR. </td>
                             
                          </tr>
                           
                          <tr  class="text-center">
                              <td colspan="5"></td>
                              <td colspan="8"></td>
                              <td colspan="5"></td>
                          </tr>
                      </table>

                      <table class="table table-bordered " style=" display: block; overflow-x: auto;">
                        <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="13">ACTIVIDADES PREVENTIVAS Y OTROS </td>
                              <td colspan="7">VACUNAS N° DE DOSIS </td>
                          </tr>

                          <tr  class="text-center">
                              <td colspan="2" style="background-color: #d0d0d0d0"> PESO (kg)</td>
                              <td colspan="2"></td>
                              <td colspan="2" style="background-color: #d0d0d0d0">TALLA (cm)</td>
                              <td colspan="2"></td>
                              <td colspan="3" style="background-color: #d0d0d0d0">P.A.(mmHg)</td>
                              <td colspan="2"> / </td>
                              <td colspan="1" style="background-color: #d0d0d0d0"> BCG</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">INFLUENZA</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ANTIAMARILICA</td>
                              <td colspan="2"></td>
                          </tr>

                          <tr  class="text-center">
                              <td colspan="2" style="background-color: #d0d0d0d0"> DE LA GESTANTE</td>
                              <td colspan="5" style="background-color: #d0d0d0d0">DEL RECIEN NACIDO</td>
                              <td colspan="4" style="background-color: #d0d0d0d0">GESTANTE/RN/NIÑO/ADOLESCENTE/JOVEN Y ADULTO/ADULTO MAYOR</td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> JOVEN ADULTO</td>
                              <td colspan="1" style="background-color: #d0d0d0d0"> DPT</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">PAROTID</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ANTINEUMOC</td>
                              <td colspan="2"></td>
                          </tr>

                          <tr  class="text-center">
                              <td colspan="1" style="background-color: #d0d0d0d0"> CPN (N°)</td>
                              <td colspan="1"></td>
                              <td colspan="3" style="background-color: #d0d0d0d0">EDAD GEST RN (SEM)</td>
                              <td colspan="2"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">CRED N°</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">PAB (cm)</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">EVALUACIÓN INTEGRAL</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">APO</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">RUBEOLA</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ANTITETANICA</td>
                              <td colspan="2"></td>
                          </tr>

                           <tr  class="text-center">
                              <td colspan="1" style="background-color: #d0d0d0d0"> EDAD GEST</td>
                              <td colspan="1"></td>
                              <td rowspan="2" colspan="1">APGAR</td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">1°</td>
                              <td rowspan="2" colspan="1" ></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">5°</td>
                              <td rowspan="2" colspan="1" ></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">RN PREMATURO</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">TAP/EEDP o TEPSI</td>
                              <td colspan="1"></td>
                              <td colspan="2" style="background-color: #d0d0d0d0">ADULTO MAYOR</td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ASA</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ROTAVIRUS</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">COMPLETAS PARA LA EDAD</td>
                              <td colspan="1">SI</td>
                              <td colspan="1">NO</td>
                          </tr>

                           <tr  class="text-center">
                              <td colspan="1" style="background-color: #d0d0d0d0"> ALTURA UTERINA</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">BAJO PESO AL NACER</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">CONSEJERIA NUTRICIONAL</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">VACAM</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">SPR</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">DT ADULTO (N° DOSIS)</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">VPH</td>
                              <td colspan="2"></td>
                          </tr>

                           <tr  class="text-center">
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0"> PARTO VERTICAL</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="4" style="background-color: #d0d0d0d0">Corte Tardio de Cordón (2 a 3 min)</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">ENFER. CONGENITA/SECUELA AL NACER</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">CONSEJERIA INTEGRAL</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">TAMIZAJE DE SALUD MENTAL</td>
                              <td colspan="1">PAT.</td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">SR</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">IPV</td>
                              <td rowspan="2" colspan="1"></td>
                              <td rowspan="2" colspan="1" style="background-color: #d0d0d0d0">VARICELA</td>
                              <td rowspan="2" colspan="2"></td>
                          </tr>
                           <tr  class="text-center">
                              <td colspan="1">NOR.</td>
                          </tr>

                           <tr  class="text-center">
                              <td colspan="1" style="background-color: #d0d0d0d0"> CONTROL PUERP(N°)</td>
                              <td colspan="1"></td>
                              <td colspan="5"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">N° FAIMLIARES DE GEST /PUERP.CASA.MAT</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">IMC (kg/M<sup>2</sup>)</td>
                              <td colspan="1"></td>
                              <td colspan="2"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">HVB</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">PENTAVAL</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">OTRA VACUNA</td>
                              <td colspan="2"></td>
                              
                          </tr>

                          <tr  class="text-center">
                              <td colspan="13"></td>
                              <td colspan="2" style="background-color: #d0d0d0d0"> GRUPO DE RIESGO HVB</td>
                              <td colspan="1"></td>
                              <td colspan="4" style="background-color: #d0d0d0d0">GRUPO DE RIESGO HVB: 1.TRABAJADOR DE SALUD 2.TRABAJAD. SEXUALES 3.HSH 4. PRIVADO LIBERTAD 5.FF.AA 6.POLICIA NACIONAL 7.ESTUDIANTES DE SALUD 8.POLITRANFUNDIDOS 9.DROGODEPENDIENTES</td>
                          </tr>



                      </table>

                      <table class="table table-bordered ">
                        <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="19">DIAGNÓSTICOS </td>
                          </tr>

                          <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td rowspan="2" colspan="1">N° </td>
                              <td colspan="6" rowspan="2" colspan="1">DESCRIPCIÓN </td>
                              <td colspan="6">INGRESO</td>
                              <td colspan="5">EGRESO </td>
                          </tr>

                           <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="3">TIPO DE DX</td>
                              <td colspan="3">CIE-10 </td>
                              <td colspan="2">TIPO DE DX</td>
                              <td colspan="3">CIE-10 </td>
                          </tr>

                          <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="1">1</td>
                              <td colspan="6"></td>
                              <td colspan="1">P</td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                          </tr>
                             <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="1">2</td>
                              <td colspan="6"></td>
                              <td colspan="1">P</td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                          </tr>

                             <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="1">3</td>
                              <td colspan="6"></td>
                              <td colspan="1">P</td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                          </tr>

                             <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="1">4</td>
                              <td colspan="6"></td>
                              <td colspan="1">P</td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                          </tr>

                             <tr class="text-center">
                              <td style="background-color: #d0d0d0d0" colspan="1">5</td>
                              <td colspan="6"></td>
                              <td colspan="1">P</td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                              <td colspan="1">D</td>
                              <td colspan="1">R</td>
                              <td colspan="3"></td>
                          </tr>

                      </table>


                      <table class="table table-bordered " >
                        <tr style="background-color: #d0d0d0d0" class="text-center">
                              <td colspan="1">N° DNI </td>
                              <td colspan="4">NOMBRE DEL RESPONSABLE DE LA ATENCIÓN </td>
                              <td colspan="2">N° DE LA COLEGIATURA </td>
                          </tr>

                           <tr class="text-center">
                              <td colspan="1"></td>
                              <td colspan="1"></td>
                              <td colspan="1"></td>
                          </tr>
                          <tr class="text-center">
                              <td colspan="1" style="background-color: #d0d0d0d0">RESPONSABLE DE LA ATENCIÓN</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">ESPECIALIDAD</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">N° RNE</td>
                              <td colspan="1"></td>
                              <td colspan="1" style="background-color: #d0d0d0d0">EGRESADO</td>
                              <td colspan="1"></td>
                          </tr>
                      </table>
<!-- FIN CARD BODY 
                       <table class="table table-bordered " style="display: block; overflow-x: auto;">
                        
                          <tr class="text-center">
                              <td colspan="1" >1.MÉDICO</td>
                              <td colspan="1" >2.FARMACEUTICO</td>
                              <td colspan="1" >3.CIRUJANO DENTISTA</td>
                              <td colspan="1" >4.BIÓLOGO</td>
                              <td colspan="1" >5.OBSTETRA</td>
                              <td colspan="1" >6.ENFERMERA</td>
                              <td colspan="1" >7.TRABAJADORA SOCIAL</td>
                              <td colspan="1" >8.PSICOLOGIA</td>
                              <td colspan="1" >9.BIÓLOGO</td>
                              <td colspan="1" >10.OBSTETRA</td>
                              <td colspan="1" >11.TECNICO DE ENFERMERIA</td>
                              <td colspan="1" >12.AUXILIAR DE ENFERMERIA</td>
                              <td colspan="1" >13.OTRO</td>
                              <td rowspan="5" colspan="3" ></td>
                          </tr>
                          

                         
                       </table>
                         -->
                       <div class="form-group col-lg-12 row text-center">
                         <div class="form-group col-lg-12 row text-center">
                            <label style="font-size:10px">1.MÉDICO 2.FARMACEUTICO 3.CIRUJANO DENTISTA 4.BIÓLOGO 5.OBSTETRA 6.ENFERMERA 7.TRABAJADORA SOCIAL 8.PSICOLOGIA 9.BIÓLOGO 10.OBSTETRA 11.TECNICO DE ENFERMERIA 12.AUXILIAR DE ENFERMERIA 13.OTRO</label> 
                            </div>
                        <div class="col-sm-4">
                           <br> <br> <br> <br> <br> <br>
                           <hr>
                            <label class="form-control-label">FIRMA Y SELLO DEL RESPONSABLE DE LA ATENCIÓN</label>
                        </div>
                          <div class="col-sm-3">
                            <LABEL>ASEGURADO</LABEL> <input type="checkbox" name="">
                            <br>
                            <LABEL>APODERADO</LABEL>  <input type="checkbox" name="">
                            <br>  <br>  <br>
                            <LABEL>APODERADO:</LABEL>
                             <br>  <br>  <br>
                            <LABEL>NOMBRES Y APELLIDOS</LABEL>
                             <br>
                              <br>
                              <br>
                              <br>
                            <LABEL>DNI O CE DEL APODERADO:</LABEL>

                        </div>
                        <div class="col-sm-3 text-center">
                           <br> <br>
                          <hr>
                            <label class=" form-control-label">FIRMA</label>
                            
                          <hr>
                             <label class=" form-control-label"><hr></label>
                            
                          <hr>
                          <br>
                           <label class=" form-control-label"><hr></label>
                            
                          <hr>
                
                        </div>
                          <div class="col-sm-2  text-center" style="border: solid; margin-top: 50px; margin-bottom: 50px;" >
                             <br>

                           
                        </div>
                         <div class="col-sm-10"></div>
                     <div class="col-sm-2"> <label style="font-size: 15px"> HUELLA DIGITAL DEL ASEGURADO O DEL APODERADO</label></div>

                      </div>
                                                             
                                                                                                                    
                                                            </div>

                                                           
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->

                                                    <div class="space-20"></div>

                                                
                                                </div><!-- /#home -->

                                                <div id="feed" class="tab-pane">
                                                    <div class="row">
                                                               

                                                        <div class="col-xs-12 col-sm-10">
                                                           

                                                            <div class="profile-user-info">
                                                              
                                                            <table class="table table-bordered " style=" display: block; overflow-x: auto;>
                                                               <tr  class="text-center">
                                                                    <td rowspan="2" colspan="6" style="background-color: #d0d0d0d0">TERAPEUTICA, INSUMOS, PROCEDIMIENTOS Y APOYO AL DIANOSTICO</td>
                                                                    <td row span="2" colspan="2"></td>
                                                                    <td colspan="6" style="background-color: #d0d0d0d0">FORMATO DE ATENCIÓN N°</td>
                                                                   
                                                                </tr>
                                                                <tr class="text-center">
                                                                     <td colspan="4"></td>
                                                                    <td colspan="2"></td>
                                                                    
                                                          
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="14" style="background-color: #d0d0d0d0">MEDICAMENTOS</td>
                                                                </tr>
                                                                <tr class="text-center" style="background-color: #d0d0d0d0">
                                                                    <td colspan="1">CÓDIGO SISMED</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">FF</td>
                                                                    <td colspan="1">CONCENTER</td>
                                                                    <td colspan="1">PRESS</td>
                                                                    <td colspan="1">ENTR</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">CÓDIGO SISMED</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">FF</td>
                                                                    <td colspan="1">CONCENTER</td>
                                                                    <td colspan="1">PRESS</td>
                                                                    <td colspan="1">ENTR</td>
                                                                    <td colspan="1">DX</td>
                                                                 
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00200</td>
                                                                    <td colspan="1">ACIDO FOLICO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500 ug (0.5mg)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03191</td>
                                                                    <td colspan="1">ERITROMICINA(COMO ESTEARATO O ETILSUCCINATO)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                 
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">03513</td>
                                                                    <td colspan="1">ACIDO FOLICO + FERROSO SULFATO (Equiv. de Hierro elemental)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">400 ug+60 mg Fe</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03182</td>
                                                                    <td colspan="1">ERITROMICINA(COMO ESTEARATO O ETILSUCCINATO)</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">250mg/5mL-60ml</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                 
                                                                </tr>
                                                                 <tr class="text-center">
                                                                    <td colspan="1">00143</td>
                                                                    <td colspan="1">ACICLOVIR</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">200mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03078</td>
                                                                    <td colspan="1">ENALAPRIL MALEATO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">10mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                 
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00903</td>
                                                                    <td colspan="1">ATORVASTATINA (COMO SAL CALCICA)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">20mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03213</td>
                                                                    <td colspan="1">ESCOPOLAMINA N-BUTILBROMURO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">20mg/mL-1mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                 
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00947</td>
                                                                    <td colspan="1">AZITROMICINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03451</td>
                                                                    <td colspan="1">FENITOINA SODICA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">100mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                 
                                                                </tr>

                                                               
                                                                <tr class="text-center">
                                                                    <td colspan="1">00259</td>
                                                                    <td colspan="1">ALBENDAZOL</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">100mg/5mL-SUS-20mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">3576</td>
                                                                    <td colspan="1">FITOMENADIONA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">10mg/mL-1mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                               
                                                                <tr class="text-center">
                                                                    <td colspan="1">00269</td>
                                                                    <td colspan="1">ALBENDAZOL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">200mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03552</td>
                                                                    <td colspan="1">FERROSO SULFATO(Equiv.60 mg Hierro)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">300mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>


                                                                <tr class="text-center">
                                                                    <td colspan="1">18091</td>
                                                                    <td colspan="1">ALUMINIO HIDROXIDO+MAGNESIO HIDROXIDO</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">400+400mg/5mL_SUS-150mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03536</td>
                                                                    <td colspan="1">FERROSO SULFATO HEPTAHIDRATO (30mL)</td>
                                                                    <td colspan="1">SOL</td>
                                                                    <td colspan="1">25mg de Fe/mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00625</td>
                                                                    <td colspan="1">AMIKACINA (COMO SULFATO)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">100 mg-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">28551</td>
                                                                    <td colspan="1">HIERRO POLIMALTOZA</td>
                                                                    <td colspan="1">SOL</td>
                                                                    <td colspan="1">50 mg/mL -20ml</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00725</td>
                                                                    <td colspan="1">AMOXICILINA+ACIDO CLAVULCANICO (COMO SAL POTASICA)</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">250mg+62.5mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03519</td>
                                                                    <td colspan="1">FERROSO SULFATO (180mL)</td>
                                                                    <td colspan="1">JBE</td>
                                                                    <td colspan="1">15 mg de Fe/5 mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00750</td>
                                                                    <td colspan="1">AMOXICILINA+ACIDO CLAVULCANICO (COMO SAL POTASICA)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg+125mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03703</td>
                                                                    <td colspan="1">FURAZOLIDONA</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">50MG/5Ml-120Ml</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">00807</td>
                                                                    <td colspan="1">AMOXICILINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">250 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03708</td>
                                                                    <td colspan="1">FURAZOLIDONA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">100 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">00794</td>
                                                                    <td colspan="1">AMOXICILINA</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">250mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03595</td>
                                                                    <td colspan="1">FLUCONAZOL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">150 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">00808</td>
                                                                    <td colspan="1">AMOXICILINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03751</td>
                                                                    <td colspan="1">GENTAMICINA-COMO SULFATO (Equivale 80g)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">40mg/mL-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">18155</td>
                                                                    <td colspan="1">AMPICILINA (COMO SAL SODICA) CON DILUYENTE</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1 g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03747</td>
                                                                    <td colspan="1">GENTAMICINA-COMO SULFATO (Equivale 160g)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">80mg/mL-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00909</td>
                                                                    <td colspan="1">ATROPINA SULFATO - 500ug/mL (0.5mg/mL)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1 mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03758</td>
                                                                    <td colspan="1">GLIBENCLAMIDA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">5mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">00091</td>
                                                                    <td colspan="1">ACIDO ACETILSALICILICO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">100 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04024</td>
                                                                    <td colspan="1">IBUPROFENO</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">100mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">01012</td>
                                                                    <td colspan="1">BECLOMETASONA DIPROPIONATO</td>
                                                                    <td colspan="1">AER</td>
                                                                    <td colspan="1">50 ug/DOSIS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04034</td>
                                                                    <td colspan="1">IBUPROFENO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">400mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">01009</td>
                                                                    <td colspan="1">BECLOMETASONA DIPROPIONATO</td>
                                                                    <td colspan="1">AER</td>
                                                                    <td colspan="1">250 ug/DOSIS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04394</td>
                                                                    <td colspan="1">LIDOCAINA CLORHIDRATO+EPINEFRINA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">20mg+10ug/mL-1.8mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01032</td>
                                                                    <td colspan="1">BENCILPENICILINA SODICA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1000000UI</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04390</td>
                                                                    <td colspan="1">LIDOCAINA CLORHIDRATO SIN PRESERVANTES</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">2g/100mL(2%)20mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">18291</td>
                                                                    <td colspan="1">BENCILPENICILINA PROCAINICA CON DILUYENTE</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1000000UI</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04415</td>
                                                                    <td colspan="1">LIDOCAINA CLORHIDRATO</td>
                                                                    <td colspan="1">GEL</td>
                                                                    <td colspan="1">2g/100g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01205</td>
                                                                    <td colspan="1">BETAMETASONA (COMO DIPROPIONATO)</td>
                                                                    <td colspan="1">CRM</td>
                                                                    <td colspan="1">50mg/100g(0.05%)20g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04523</td>
                                                                    <td colspan="1">LOSARTAN POTÁSICO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">50 mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">18153</td>
                                                                    <td colspan="1">BENZATINA BENCILPENICILINA CON DILUYENTE</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1200000UI</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04582</td>
                                                                    <td colspan="1">MEBENDAZOL</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">100mg/5mL-30mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">18048</td>
                                                                    <td colspan="1">BENZATINA BENCILPENICILINA CON DILUYENTE</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">2400000UI</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04677</td>
                                                                    <td colspan="1">METAMIZOL SODICO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1g-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01522</td>
                                                                    <td colspan="1">CAPTOPRIL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">25mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04794</td>
                                                                    <td colspan="1">METRONIDAZOL (COMO BENZOATO)</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">250mg/5mL-120mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01532</td>
                                                                    <td colspan="1">CARBAMAZEPINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">200mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04805</td>
                                                                    <td colspan="1">METRONIDAZOL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">01684</td>
                                                                    <td colspan="1">CEFTRIAXONA SODICA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">20575</td>
                                                                    <td colspan="1">OTRA COMBINACIONES DE MULTIVITAMINAS-POLVO</td>
                                                                    <td colspan="1">POLVO</td>
                                                                    <td colspan="1">1g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01846</td>
                                                                    <td colspan="1">CIPROFLOXACINO (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04696</td>
                                                                    <td colspan="1">METFORMINA CLORHIDRATO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">850mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">01841</td>
                                                                    <td colspan="1">CIPROFLOXACINO (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">SOL-OFT</td>
                                                                    <td colspan="1">3 mg/mL(0.3%)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">04982</td>
                                                                    <td colspan="1">NAPROXENO (COMO SAL SODICA)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02496</td>
                                                                    <td colspan="1">COMPLEJO B</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05103</td>
                                                                    <td colspan="1">NITROFURANTOINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">100mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">01964</td>
                                                                    <td colspan="1">CLINDAMICINA (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">CAP</td>
                                                                    <td colspan="1">300mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05154</td>
                                                                    <td colspan="1">OMEPRAZOL</td>
                                                                    <td colspan="1">CAP_LM</td>
                                                                    <td colspan="1">20mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">01958</td>
                                                                    <td colspan="1">CLINDAMICINA (COMO FOSFATO)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">600mg-4mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05211</td>
                                                                    <td colspan="1">OXACILINA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">1g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02128</td>
                                                                    <td colspan="1">CLORFENAMINA MALEATO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">10mg/mL-1mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05253</td>
                                                                    <td colspan="1">OXITOCINA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">10UI-1mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">02132</td>
                                                                    <td colspan="1">CLORFENAMINA MALEATO</td>
                                                                    <td colspan="1">JBE</td>
                                                                    <td colspan="1">2mg/5mL-120mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05281</td>
                                                                    <td colspan="1">PARACETAMOL</td>
                                                                    <td colspan="1">SOL</td>
                                                                    <td colspan="1">100mg/mL-10mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02149</td>
                                                                    <td colspan="1">CLORFENAMINA MALEATO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">4mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05309</td>
                                                                    <td colspan="1">PARACETAMOL</td>
                                                                    <td colspan="1">JBE</td>
                                                                    <td colspan="1">120mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">02354</td>
                                                                    <td colspan="1">CLOTRIMAZOL</td>
                                                                    <td colspan="1">OVU</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05335</td>
                                                                    <td colspan="1">PARACETAMOL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02319</td>
                                                                    <td colspan="1">CLOTRIMAZOL</td>
                                                                    <td colspan="1">CRM</td>
                                                                    <td colspan="1">1g/100g(1%)20g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05551</td>
                                                                    <td colspan="1">POTASIO CLORURO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">20g/100mL(20%)10mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">20635</td>
                                                                    <td colspan="1">CALCIO CARBONATO(Equivale 500mg)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">1.25g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05589</td>
                                                                    <td colspan="1">PREDNISONA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">5mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">02657</td>
                                                                    <td colspan="1">DEXAMETASONA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">4mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05590</td>
                                                                    <td colspan="1">PREDNISONA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">50mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                  <tr class="text-center">
                                                                    <td colspan="1">02654</td>
                                                                    <td colspan="1">DEXAMETASONA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500ug(0.5mg)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05586</td>
                                                                    <td colspan="1">PREDNISONA (120mL)</td>
                                                                    <td colspan="1">JBE</td>
                                                                    <td colspan="1">5 mg/5-mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">02642</td>
                                                                    <td colspan="1">DEXAMETASONA FOSFATO (COMO SAL SÓDICA)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">4mg/2mL-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">08153</td>
                                                                    <td colspan="1">RETINOL</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">200000UI</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02724</td>
                                                                    <td colspan="1">DEXTROMETORFANO BROMHIDRATO</td>
                                                                    <td colspan="1">JBE</td>
                                                                    <td colspan="1">15mg/5mL-120mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05658</td>
                                                                    <td colspan="1">RANITIDINA (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">25mg/mL-2mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">03789</td>
                                                                    <td colspan="1">DEXTROSA</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">5g/100mL(5%)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05660</td>
                                                                    <td colspan="1">RANITIDINA (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">150mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">03787</td>
                                                                    <td colspan="1">DEXTROXA</td>
                                                                    <td colspan="1">NY</td>
                                                                    <td colspan="1">33m3g/mL(33%)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05661</td>
                                                                    <td colspan="1">RANITIDINA (COMO CLORHIDRATO)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">300mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">02835</td>
                                                                    <td colspan="1">DICLOXACILINA (COMO SAL SODICA)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">250mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">20036</td>
                                                                    <td colspan="1">SALES DE REHIDRATACIÓN ORAL</td>
                                                                    <td colspan="1">PLV</td>
                                                                    <td colspan="1">20.5 g/L</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02836</td>
                                                                    <td colspan="1">DICLOXACILINA (COMO SAL SODICA)</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">500mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05731</td>
                                                                    <td colspan="1">SALBUTAMOL (COMO SULFATO)</td>
                                                                    <td colspan="1">AER</td>
                                                                    <td colspan="1">100ug/200 DOSIS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02830</td>
                                                                    <td colspan="1">DICLOXACILINA (COMO SAL SODICA)</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">250mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05986</td>
                                                                    <td colspan="1">SULFAMETOXAZOL+TRIMETOPRIMA</td>
                                                                    <td colspan="1">SUS</td>
                                                                    <td colspan="1">200mg+40mg/5mL-60mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02788</td>
                                                                    <td colspan="1">DICLOFENACO SODICO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">25mg/mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">03515</td>
                                                                    <td colspan="1">SULFAMETOXAZOL+TRIMETOPRIMA</td>
                                                                    <td colspan="1">RAB</td>
                                                                    <td colspan="1">800mg + 160mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>


                                                                 <tr class="text-center">
                                                                    <td colspan="1">02891</td>
                                                                    <td colspan="1">DIMENHIDRINATO</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">50mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05873</td>
                                                                    <td colspan="1">SODIO CLORURO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">900mg/100mL(0.9%)1L</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">02884</td>
                                                                    <td colspan="1">DIMENHIDRINATO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">50mg-5mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">05889</td>
                                                                    <td colspan="1">SODIO CLORURO</td>
                                                                    <td colspan="1">INY</td>
                                                                    <td colspan="1">20g/100mL(20%)20mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">03018</td>
                                                                    <td colspan="1">DOXICICLINA</td>
                                                                    <td colspan="1">TAB</td>
                                                                    <td colspan="1">100mg</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">06111</td>
                                                                    <td colspan="1">TETRACICLINA CLORHIDRATO</td>
                                                                    <td colspan="1">UNG_OF</td>
                                                                    <td colspan="1">1g/100g(1%)6g</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="12" style="background-color: #d0d0d0d0">INSUMOS COMPLEMENTARIOS</td>
                                                                </tr>
                                                                <tr class="text-center" style="background-color: #d0d0d0d0">
                                                                    <td colspan="1">CÓDIGO</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">IND</td>
                                                                    <td colspan="1">EJE</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">RES</td>
                                                                    <td colspan="1">CÓDIGO</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">IND</td>
                                                                    <td colspan="1">EJE</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">RES</td>
                                                                 
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">16570</td>
                                                                    <td colspan="1">GUANTE QUIRURGICO DESCARTABLE ESTERIL 7 (PAR)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">10477</td>
                                                                    <td colspan="1">CATETER ENDOVENOSO PERIFERICO N° 22 G X 1"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">10929</td>
                                                                    <td colspan="1">EQUIPO DE VENOCLISIS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">10421</td>
                                                                    <td colspan="1">CATETER ENDOVENOSO PERIFERICO N° 18 G X 1 1/4"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">16657</td>
                                                                    <td colspan="1">JERINGA DESCARTABLE 3 mL CON AGUJA 21 G X 1/2"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">22256</td>
                                                                    <td colspan="1">CATETER ENDOVENOSO PERIFERICO N° 20 G X 1 1/4"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">11370</td>
                                                                    <td colspan="1">JERINGA DESCARTABLE 5 mL CON AGUJA 21 G X 1/2"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">20596</td>
                                                                    <td colspan="1">AEROCAMARA NEONATAL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                  <tr class="text-center">
                                                                    <td colspan="1">11368</td>
                                                                    <td colspan="1">JERINGA DESCARTABLE 10 mL CON AGUJA 21 G X 1/2"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">10051</td>
                                                                    <td colspan="1">AEROCAMARA PEDIATRICA</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                   <tr class="text-center">
                                                                    <td colspan="1">11369</td>
                                                                    <td colspan="1">JERINGA DESCARTABLE 20 mL CON AGUJA 21 G X 1/2"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">10482</td>
                                                                    <td colspan="1">CATETER ENDOVENOSO PERIFERICO N° 24 G X 3/4"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">19875</td>
                                                                    <td colspan="1">JERINGA DESCARTABLE DE TUBERCULINA 1 mL CON AGUJA 25G X 5/8"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">36203</td>
                                                                    <td colspan="1">PASTA DENTRIFICA CON FLUOR 1000ppm-1500 PPM 90g (UNIDAD)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">10155</td>
                                                                    <td colspan="1">AGUJA HIPODERMICA DESCARTABLE N° 23 G X 1"</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">36222</td>
                                                                    <td colspan="1">PASTA DENTRIFICA CON FLUOR 1000ppm-1500 PPM 100g (UNIDAD)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                  <tr class="text-center">
                                                                    <td colspan="1">23631</td>
                                                                    <td colspan="1">FRASCO DE PLASTICO PARA MUESTRA DE ORINA 60 mL</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">36223</td>
                                                                    <td colspan="1">PASTA DENTRIFICA CON FLUOR 1000ppm-1500 PPM 50g (UNIDAD)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">28777</td>
                                                                    <td colspan="1">Microcubeta descartable para Hemoglobinómetro portatil</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">15778</td>
                                                                    <td colspan="1">CEPILLO DENTAL PARA ADULTOS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                  <tr class="text-center">
                                                                    <td colspan="1">23311</td>
                                                                    <td colspan="1">Microcubeta para equipo Hemocue x 50</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">15779</td>
                                                                    <td colspan="1">CEPILLO DENTAL PARA NIÑOS</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">28779</td>
                                                                    <td colspan="1">Microcubeta descartable para Hemoglobinómetro Hemocue HB 201 x 50</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="12" style="background-color: #d0d0d0d0">PROCEDIMIENTOS/DIAGNOSTICO POR IMAGENES/LABORATORIO</td>
                                                                </tr>
                                                                <tr class="text-center" style="background-color: #d0d0d0d0">
                                                                    <td colspan="1">CÓDIGO</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">IND</td>
                                                                    <td colspan="1">EJE</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">RES</td>
                                                                    <td colspan="1">CÓDIGO</td>
                                                                    <td colspan="1">NOMBRE</td>
                                                                    <td colspan="1">IND</td>
                                                                    <td colspan="1">EJE</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">RES</td>
                                                                 
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">D1225</td>
                                                                    <td colspan="1">Aplicación de barniz fluorado</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">86592</td>
                                                                    <td colspan="1">Prueba rápida/Text cualitativo para Sifilis (VDRL,RPR)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">D1204</td>
                                                                    <td colspan="1">Aplicación tópica de flúor en adultos, inluido profilaxis dental</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">86701</td>
                                                                    <td colspan="1">Prueba rápida para HIV/Text de Elisa para VIH</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">D1205</td>
                                                                    <td colspan="1">Aplicación tópica de flúor en adultos, sin profilaxis dental</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">85018</td>
                                                                    <td colspan="1">Hemoglobina</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">D1201</td>
                                                                    <td colspan="1">Aplicación tópica de flúor en niños, incluido profilaxis dental (Aplicación de flúor gel acidula)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">81005</td>
                                                                    <td colspan="1">Examen completo de orina</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">D1110</td>
                                                                    <td colspan="1">Profilaxis dental en adultos</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">86899</td>
                                                                    <td colspan="1">Grupo sanguíneo y factor Rh</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>


                                                                 <tr class="text-center">
                                                                    <td colspan="1">D1120</td>
                                                                    <td colspan="1">Profilaxis dental en niños</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">82947</td>
                                                                    <td colspan="1">Glucosa Basal</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">99255</td>
                                                                    <td colspan="1">Examen Bucal</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">80076</td>
                                                                    <td colspan="1">Perfil Hepatico (TGO, TGP, GGTP, Bilirrubina total y fraccionadas)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">97782</td>
                                                                    <td colspan="1">Fisioterapia Odontoesmatológica</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">85031</td>
                                                                    <td colspan="1">Hemograma completo, 3ra. generación (N°, Fórmula, Hb, Hto, Constantes corpusculares, Plaquet)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">41708</td>
                                                                    <td colspan="1">Extracción dental simple</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">82565</td>
                                                                    <td colspan="1">Creatinina</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">TJ001</td>
                                                                    <td colspan="1">Destartraje</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">87177</td>
                                                                    <td colspan="1">Examen seriado parasitologico</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">10060</td>
                                                                    <td colspan="1">Incisión y drenaje de abscesos</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">80061</td>
                                                                    <td colspan="1">Perfil lipídico(Colesterol total, HDL, LDL, VLDL, Trigliceridos y líidos totales)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">41720</td>
                                                                    <td colspan="1">Tratamientos restauradores (con amalgama, silicato, otros materiales)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">84478</td>
                                                                    <td colspan="1">Triglicéridos</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">13301b</td>
                                                                    <td colspan="1">Curacion quirurg. Mediana</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">82465</td>
                                                                    <td colspan="1">Colesterol total</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>


                                                                 <tr class="text-center">
                                                                    <td colspan="1">13301a</td>
                                                                    <td colspan="1">Curacion quirurg. Pequña</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">84540</td>
                                                                    <td colspan="1">Urea en orina</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">59409</td>
                                                                    <td colspan="1">Parto vaginal solamente</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">85013</td>
                                                                    <td colspan="1">Hematocrito</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">99402</td>
                                                                    <td colspan="1">Consejeria Planificación Familiar</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">85590</td>
                                                                    <td colspan="1">Recuento de plaquetas</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">88141</td>
                                                                    <td colspan="1">Papanicolau</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">94640</td>
                                                                    <td colspan="1">Nebulización con presión positiva intermitente</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">88141.01</td>
                                                                    <td colspan="1">Inspección Visual con ácido acético (IVAA)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">84153</td>
                                                                    <td colspan="1">PSA (Antigeno prostatico especifico)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>


                                                                <tr class="text-center">
                                                                    <td colspan="1">59400</td>
                                                                    <td colspan="1">Atención Prenatal</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">90471</td>
                                                                    <td colspan="1">Administración de inmunización (incluye inyecciones percutáneas, intradérmicas, subcutáneos,in)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                  <tr class="text-center">
                                                                    <td colspan="1">99211</td>
                                                                    <td colspan="1">Consulta ambulatoria para la evaluación y manejo de un paciente continuadora (Control Puerperal)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">99349</td>
                                                                    <td colspan="1">Consulta a domicilio para le manejo y evaluación de un paciente continuador de gravedad moderada</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">81025</td>
                                                                    <td colspan="1">Pregnosticon (diagnostico de embarazo) all in</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">12001</td>
                                                                    <td colspan="1">Sutura simple de heridas superficiales, de 2,5 cm o menos</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">76856</td>
                                                                    <td colspan="1">Ecografía pélvica (útero y anexos)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">99411</td>
                                                                    <td colspan="1">Estimulacion Temprana</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">76830</td>
                                                                    <td colspan="1">Ecografía transvaginal</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">99207</td>
                                                                    <td colspan="1">Atención en Salud Mental</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">76805</td>
                                                                    <td colspan="1">Ecografía obstétrica</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">87172</td>
                                                                    <td colspan="1">Text de graham</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">76700</td>
                                                                    <td colspan="1">Ecografía abdominal</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">13302</td>
                                                                    <td colspan="1">Extracción de puntos</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">99381</td>
                                                                    <td colspan="1">Atención integral de Salud del Niño-Cred menor de 1 año</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">99403</td>
                                                                    <td colspan="1">Consejeria nutricional</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="1">99382</td>
                                                                    <td colspan="1">Atención integral de Salud del Niño-Cred de 1 a 4 años</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">87207</td>
                                                                    <td colspan="1">Gota gruesa</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">99383</td>
                                                                    <td colspan="1">Atención integral de Salud del Niño-Cred de 5 a 11 años</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1">99384</td>
                                                                    <td colspan="1">Atención inicial y exhaustiva de medicina preventiva para adolescnte (12 a 17 años)</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="1">99173</td>
                                                                    <td colspan="1">Tamizaje de Agudeza Visual</td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="2" style="background-color: #d0d0d0d0">R.Ojo izquierdo</td>
                                                                    <td colspan="1">   /  </td>
                                                                     <td colspan="2" style="background-color: #d0d0d0d0">R.Ojo derecho</td>
                                                                    <td colspan="1">   /  </td>
                                                                    <td colspan=""></td>
                                                                </tr>

                                                                 <tr class="text-center">
                                                                    <td colspan="12" style="background-color: #d0d0d0d0">SUB COMPONENTE PRESTACIONAL(MEDICAMENTOS, INSUMOS Y/O PROCEDIMIENTOS)</td>
                                                                </tr>
                                                                <tr class="text-center" style="background-color: #d0d0d0d0">
                                                                    <td colspan="1">CÓDIGO</td>
                                                                    <td colspan="3">NOMBRE</td>
                                                                    <td colspan="2">CARACT</td>
                                                                    <td colspan="1">IND/PRESS</td>
                                                                    <td colspan="1">EJE/ENTR</td>
                                                                    <td colspan="1">DX</td>
                                                                    <td colspan="1">RES</td>
                                                                    <td colspan="1">N° TICKET</td>
                                                                    <td colspan="1">PO</td>
                                                                </tr>

                                                                <tr class="text-center" >
                                                                    <td colspan="1"></td>
                                                                    <td colspan="3"></td>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>
                                                                 <tr class="text-center" >
                                                                    <td colspan="1"></td>
                                                                    <td colspan="3"></td>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                    <td colspan="1"></td>
                                                                </tr>

                                                                <tr class="text-center">
                                                                    <td colspan="12" style="background-color: #d0d0d0d0">OBSERVACIONES</td>
                                                                </tr>
                                                                <tr class="text-center">
                                                                    <td colspan="1"></td>
                                                                    <td colspan="11"></td>
                                                                </tr>
                                                                 <tr class="text-center">
                                                                    <td colspan="1"></td>
                                                                    <td colspan="11"></td>
                                                                </tr>
                                                                 <tr class="text-center">
                                                                    <td colspan="1"></td>
                                                                    <td colspan="11"></td>
                                                                </tr>
                                                           
                                                            </table>
                                                             <div class="form-group col-lg-12 row text-center">
                         
                        <div class="col-sm-4">
                           <br> <br> <br> <br> <br> <br>
                           <hr>
                            <label class="form-control-label">Firma y Sello del Resposable del procedimiento Farmacia y/o Laboratorio</label>
                        </div>
                        <div class="col-sm-3">
                            <LABEL>ASEGURADO</LABEL> <input type="checkbox" name="">
                            <br>
                            <LABEL>APODERADO</LABEL>  <input type="checkbox" name="">
                            <br>  <br>  <br>
                            <LABEL>APODERADO:</LABEL>
                              <br>
                            <LABEL>NOMBRES Y APELLIDOS</LABEL>
                             <br>
                              <br>
                              <br>
                              <br>
                            <LABEL>DNI O CE DEL APODERADO:</LABEL>

                        </div>
                        <div class="col-sm-3 text-center">
                           <br> <br>
                          <hr>
                            <label class=" form-control-label">FIRMA</label>
                            <br> <br>
                          <hr>
                             <label class=" form-control-label"><hr></label>
                            <br> <br>
                          <hr>
                
                        </div>
                          <div class="col-sm-2  text-center" style="border: solid; margin-top: 50px; margin-bottom: 50px;" >
                             <br>

                           
                        </div>

                         <div class="col-sm-10"></div>
                     <div class="col-sm-2"> <label style="font-size: 15px"> HUELLA DIGITAL DEL ASEGURADO O DEL APODERADO</label></div>

                      </div>
                                                                                               
                                                                
                                                            
                                                       
                                                            </div>

                                                           
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->

                                                    <div class="space-12"></div>

                                                </div><!-- /#feed -->

                            

                                            
                                        </div>

          	
            <!-- Inicio de columnas de la página-->
         	 <div class="col-lg-12">
              <div class="line-chart-example card">
                <div class="card-close">

                </div>
                

                  <div class="card-body">
                    
                      


                   <div class="row">
                    

           
            

          

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

                  <br> <br>
                    <div class="text-center col-lg-12" >
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
                                        //tablas
                                        'librerias/datatable/jquery.dataTables.min.js',
                                        'librerias/datatable/bootstrap/dataTables.bootstrap.min.js' ,


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
