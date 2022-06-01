$(document).ready(function(){    
            
    //REGISTRAR SELECT: CICLO
    $('.select2').select2({          
        //allowClear: false , 
        minimumResultsForSearch: 7,  
       // width: '90%'    
    });
    
    //.numeric = Para ingresar sólo números en un input
    $( "#text_num_documento, #text_id_sis" ).numeric();

    
    //pop over
    $('[data-toggle="popover"]').popover({
        trigger: 'focus',  //desaparece al dar click en espacio
    });

    //validar select al cambiar ,
    $('#checkbox_posee_sis').on('change', function() {
        let estado = $(this).val() ;

        if ($('#checkbox_posee_sis').is(":checked"))
        {
            $('#contenedor_datos_sis').removeClass('d-none');
        }else {
            $('#contenedor_datos_sis').addClass('d-none');
        }
    });
    
  
   
   //crear calendario para el filtardo de fecha 
    $('#text_fecha_naci, #text_fecha_afiliacion, #text_fecha_baja').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es',      
        viewMode: 'years',            
        useCurrent: false , //rellenar el input con la fecha actual
        //defaultDate: false,  
        icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                } ,
       
       maxDate: $.now()         
    });
    
  
    
    
/*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,   
   $('#select_tipo_doc').on('change', function() {
        $(this).trigger('blur');        
    });
    
    // validar clase calendario,  (inicio/fin matricula | inicio/fin clases)
   /* $.validator.addMethod("cRequired", $.validator.methods.required,
                                           "Seleccione una fecha ");
    $.validator.addClassRules({
        calendario: {
                        cRequired: true                          
                    },
    }); */
    
      
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
    $('#form_registrar_paciente').validate({
        
          onfocusout: function(element) {
                                    this.element(element);
                            },                                        
          ignore: '#foto_empleado , .select2-input , .select2-focusser',
          
          errorClass: 'has-danger',
          
          rules: {
                    text_dni: {
                        required: true,
                        minlength: 8                                                                        
                    },
                    text_nombres: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    text_apellido_pat: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    text_apellido_mat: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    text_fecha_naci: {
                        required: true                                                                                                   
                    },
                    radio_sexo: {
                        required: true    
                    },


                                 
                },    
        messages: {                        
                    text_dni: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese 8 Dígitos',                                            
                    },
                    text_nombres: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    text_apellido_pat: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    text_apellido_mat: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    text_fecha_naci: {
                        required: 'Seleccione Fecha'                                                               
                    },
                    radio_sexo: {
                        required: 'Seleccione Sexo'    
                    },


                                         
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
    
    
    $('#select_tipo_emplea').on('change', function() {
       console.log( 'mi valor es: '  + $(this).val() ) ;    
    });
   
 
    
   
       
            

});