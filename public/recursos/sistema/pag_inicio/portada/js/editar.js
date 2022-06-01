$(document).ready(function(){    
            
     //REGISTRAR SELECT: CICLO
     $('.select2').select2({          
        //allowClear: false , 
        minimumResultsForSearch: 7,  
       // width: '90%'    
    });
    
    //Para ingresar sólo números en costo
    $( "#txt_costo" ).numeric();
    
    
    //Para ingresar sólo números 
    //spinner de jornada de clases
    $( "#txt_jornada" ).numeric();
    $( "#txt_jornada" ).spinner({
          min: 30,
          max: 60,
          step: 5 , //intervalos por salto,
          numberFormat: "n"
     });
   
   //crear calendario para el filtardo de fecha 
    $('#txt_ano').datetimepicker({
        format: 'YYYY',        
        locale: 'es',      
        viewMode: 'years',            
        useCurrent: true  //no rellenará el input con la fecha actual                 
    });
    
    //crear calendario para el filtardo de fecha 
    /*$('.calendario').datetimepicker({
        format: 'YYYY-MM-DD',        
        locale: 'es',      
        //viewMode: '',            
        useCurrent: false , //rellenar input con la fecha actual  
        icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                }               
    }); */
    
    mis_iconos = {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                    };
    console.log(FECHA_INI_MATRI);
    console.log(FECHA_FIN_MATRI);
    // Validación de limite de fechas Matrícula
    $('#txt_ini_mat').datetimepicker({
        icons: mis_iconos ,
        format: 'YYYY-MM-DD', 
        locale: 'es',
        
        maxDate: FECHA_FIN_MATRI,
        defaultDate: FECHA_INI_MATRI
    });
    $('#txt_fin_mat').datetimepicker({
        
        useCurrent: false, //Important! See issue #1075
        icons: mis_iconos ,
        format: 'YYYY-MM-DD', 
        locale: 'es',
        
        minDate: FECHA_INI_MATRI,
        defaultDate: FECHA_FIN_MATRI
    });
    $("#txt_ini_mat").on("dp.change", function (e) {
        $('#txt_fin_mat').data("DateTimePicker").minDate(e.date);
    });
    $("#txt_fin_mat").on("dp.change", function (e) {
        $('#txt_ini_mat').data("DateTimePicker").maxDate(e.date);
    });
    
     // Validación de limite de fechas Clases
    $('#txt_ini_cla').datetimepicker({
        icons: mis_iconos ,
        format: 'YYYY-MM-DD', 
        locale: 'es',
        
        maxDate: FECHA_FIN_CLASE,
        defaultDate: FECHA_INI_CLASE
    });
    $('#txt_fin_cla').datetimepicker({
        useCurrent: false, //Important! See issue #1075
        icons: mis_iconos ,
        format: 'YYYY-MM-DD', 
        locale: 'es',
        
        minDate: FECHA_INI_CLASE,
        defaultDate: FECHA_FIN_CLASE
    });
    $("#txt_ini_cla").on("dp.change", function (e) {
        $('#txt_fin_cla').data("DateTimePicker").minDate(e.date);
    });
    $("#txt_fin_cla").on("dp.change", function (e) {
        $('#txt_ini_cla').data("DateTimePicker").maxDate(e.date);
    }); 
   
   
     //crear Reloj para las horas (HORA inicio/fin del TURNO mañana/tarde)
    $('.reloj').datetimepicker({
        format: 'HH:mm',        
        locale: 'es',      
        //viewMode: '',            
        useCurrent: false , //rellenar input con la fecha actual
        stepping: 5 , //intervalo de minutos  
        icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                }               
    });
     // Validación de limite de hora  turno MAÑANA
    $('#txt_hora_ini_man').datetimepicker();
    $('#txt_hora_fin_man').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $("#txt_hora_ini_man").on("dp.change", function (e) {
        $('#txt_hora_fin_man').data("DateTimePicker").minDate(e.date);
    });
    $("#txt_hora_fin_man").on("dp.change", function (e) {
        $('#txt_hora_ini_man').data("DateTimePicker").maxDate(e.date);
    });
    
       // Validación de limite de hora  turno TARDE
     $('#txt_hora_ini_tar').datetimepicker();
    /* $("#txt_hora_fin_man").on("dp.change", function (e) {
        $('#txt_hora_ini_tar').data("DateTimePicker").minDate(e.date);
    });*/
    $('#txt_hora_fin_tar').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $("#txt_hora_ini_tar").on("dp.change", function (e) {
        $('#txt_hora_fin_tar').data("DateTimePicker").minDate(e.date);
    });
    $("#txt_hora_fin_tar").on("dp.change", function (e) {
        $('#txt_hora_ini_tar').data("DateTimePicker").maxDate(e.date);
    });
    
    
     //Para ingresar sólo números en capacidad de aulas   
     $( ".inputs-aulas-man , .inputs-aulas-tar" ).numeric();    
    
    /* cambio de select */   
    //evento select turno mañana
    $('#select_aulas_man').on('change', function (evt) {      
      //ocultar todaslas aulas
      $('.inputs-aulas-man').addClass('d-none');      
      //mostrar input del  sólo del  aula selecciona
      $('[data-id-aula-man = "'+ this.value + '" ]').removeClass('d-none');      
    });
      //evento select turno tarde
    $('#select_aulas_tar').on('change', function (evt) {      
      //ocultar todaslas aulas
      $('.inputs-aulas-tar').addClass('d-none');      
      //mostrar input del  sólo del  aula selecciona
      $('[data-id-aula-tar = "'+ this.value + '" ]').removeClass('d-none');      
    });
   
    
    
/*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,   
    $('#select_ciclo , #select_etapa').on('change', function() {
        $(this).trigger('blur');        
    });
    
    // validar clase calendario,  (inicio/fin solicitud | inicio/fin clases)
    $.validator.addMethod("cRequired", $.validator.methods.required,
                                           "Seleccione una fecha ");
    $.validator.addClassRules({
        calendario: {
                        cRequired: true                          
                    },
    });
    
    // validar clase reloj,  (inicio/fin mañana | inicio/fin tarde)
    $.validator.addMethod("relRequired", $.validator.methods.required,
                                           "Seleccione una Hora ");
    $.validator.addClassRules({
        reloj: {
                    relRequired: true                          
                },
    });
    
    // validar salones mañana
   /* $.validator.addMethod("aulaMRequired", $.validator.methods.required,
                                           "Ingrese Capacidad  "); */
    /* $.validator.addMethod("aulaMRequired", $.validator.methods.required, 
    // leverage parameter replacement for minlength, {0} gets replaced with 2
    $.validator.format("Customer name must have at least {0} characters"));
    $.validator.addClassRules({
        'inputs-aulas-man': {
                    aulaMRequired: true                          
                },
    });*/
 
         
     /* reglas/mensajes de validaciones */
    $('#form_registrar_ciclo').validate({
        
         onfocusout: function(element) {
                                    this.element(element);
                            },                                        
          //ignore: '.select2-input , .select2-focusser',
          
            errorClass: 'has-danger',
          
          rules: {
                    select_ciclo: {
                        required: true,
                        range: [1, 2]                                                                        
                    },
                    txt_ano: {
                        required: true                                                                         
                    },
                    select_etapa: {
                        required: true,
                        range: [1,3]                                                                           
                    } ,
                    txt_costo: {
                        required: true,                                                                                                  
                    },
                     txt_jornada: {
                        required: true, 
                        min: 30,
                        max: 60                                                                                                 
                    }                  
                },    
        messages: {                        
                    select_ciclo: {
                        required: 'Seleccione un tipo de ciclo',
                        range: 'Opción seleccionada no válida',                                            
                    },
                    txt_ano: {
                        required: 'Seleccione un Año',                                                     
                    },
                    select_etapa: {
                        required: 'Seleccione un tipo de ciclo',
                        range: 'Opción seleccionada no válida',                                            
                    },
                    txt_costo: {
                        required: 'Ingrese un Monto',                                                                                                
                    },
                    txt_jornada: {
                       required: 'Ingrese la jornada', 
                        min: 'Valor debe ser mayor o igual a <b>30</b>',
                        max: 'Valor debe ser menor o igual a <strong>60</strong>'                                                                                                        
                    } 
                                         
                },
        highlight: function (element) {
                       // console.log(element);                      
                                    
                        $(element).parent().parent().addClass('has-danger');                       
                  },
        unhighlight: function (element, errorClass, validClass) {
                        $(element).parent().parent().removeClass('has-danger');
          },
                    
        success: function (element) {           
                         $(element).parent().parent().removeClass('has-danger');
                         $(element).parent().parent().addClass('has-success');                         
                          $(element).html('<span class="fa fa-check" style="color: green;"> </span>');                     
        },
        errorPlacement: function (error, element) {                              
                         error.insertAfter(element.parent());           
                                                     
                        },                               
    });
    
    
   $('.inputs-aulas-man').each(function () {
       
       nom_aula = $(this).attr('data-nombre-aula-man');
       
        $(this).rules("add", {
            required: true,
            messages: { 
                        required: 'Ingrese capacidad:  <br>' + nom_aula ,
                      },
        });        
    });
        
 
    
   
       
            

});