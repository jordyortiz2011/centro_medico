$(document).ready(function(){    
            
    //REGISTRAR SELECT: CICLO
    $('.select2').select2({          
        //allowClear: false , 
        minimumResultsForSearch: 7,  
       // width: '90%'    
    });
    
    //.numeric = Para ingresar sólo números en un input
    $( "#txt_dni" ).numeric();
    $( "#txt_telefono" ).numeric();
    $( "#txt_celular" ).numeric();
    
    
    
    //pop over
    $('[data-toggle="popover"]').popover({
        trigger: 'focus',  //desaparece al dar click en espacio
    });    
    
  

  
    
    
/*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,   
   $('#select_tipo_usuario').on('change', function() {
        $(this).trigger('blur');        
    });
    
    // validar clase calendario,  (inicio/fin solicitud | inicio/fin clases)
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
    $('#form_agregar_usuario').validate({
        
          onfocusout: function(element) {
                                    this.element(element);
                            },                                        
          ignore: '#foto_usuario , .select2-input , .select2-focusser',
          
          errorClass: 'has-danger',
          
          rules: {
                    txt_dni: {
                        required: true,
                        minlength: 8                                                                        
                    },
                    txt_nombres: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    txt_apellido_pat: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    txt_apellido_mat: {
                        required: true ,
                         minlength: 2                                                                         
                    },
                    //datos de la cuenta
                    select_tipo_usuario: {
                        required: true                                                                                                   
                    },
                    txt_username: {
                        required: true,                         
                    },                   
                    txt_correo: {
                        required: true,
                        email: true,    
                    }
                 
                    
                                 
                },    
        messages: {                        
                    txt_dni: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese 8 Dígitos',                                            
                    },
                    txt_nombres: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    txt_apellido_pat: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    txt_apellido_mat: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese al menos 2 caracteres',                                                      
                    },
                    //Datos de la cuenta
                    select_tipo_usuario: {
                        required: 'Seleccione un tipo'                                                               
                    },
                    txt_username: {
                        required: 'Campo requerido',                                                              
                    },
                    txt_correo: {
                        required: 'Campo requerido',
                        email: 'Ingrese Correo Válido',    
                    }                                 
                    //datos laborales
                   
                                         
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
    
    
    $('#select_tipo_usuario').on('change', function() {
      // console.log( 'mi valor es: '  + $(this).val() ) ;    
    });
   
 
    
   
       
            

});