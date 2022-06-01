$(document).ready(function(){    
            
    //REGISTRAR SELECT: CICLO
    $('.select2').select2({          
        //allowClear: false , 
        minimumResultsForSearch: 7,  
       // width: '90%'    
    });
    
    //.numeric = Para ingresar sólo números en un input
    $( "#txt_prioridad" ).numeric();
    $( "#txt_prioridad" ).spinner({
          min: 1,
          max: 100,
          step: 1 , //intervalos por salto,
          numberFormat: "n"
     });    
    
    
    //pop over (muestra más información sobre un elemento)
    $('[data-toggle="popover"]').popover({
        trigger: 'focus',  //desaparece al dar click en espacio
    });    
    
   //para color   
   $('#div_color_texto').colorpicker({ 
       color: '#000000', 
       format: 'hex' 
     });  
     
  //para color   
   $('#div_color_fondo').colorpicker({ 
       color: '#76ffb6;', 
       format: 'hex' 
    }); 

    
    
/*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,   
   $('#select_tipo_portada').on('change', function() {
        $(this).trigger('blur');        
    });
         
     /* reglas/mensajes de validaciones */
    $('#form_agregar_portada').validate({
        
          onfocusout: function(element) {
                                    this.element(element);
                            },                                        
          ignore: ' .select2-input , .select2-focusser',
          
          errorClass: 'has-danger',
          
          rules: {
                    
                    //datos laborales
                    select_tipo_portada: {
                        required: true                                                                                                   
                    },
                    txt_prioridad: {
                        required: true,
                        number: true,                                                                        
                    },                   
                    
                                 
                },    
        messages: {                        
                    select_tipo_portada: {
                        required: 'Seleccione opción'                                                             
                    },
                    txt_prioridad: {
                        required: 'Campo requerido',
                        minlength: 'Ingrese valor númerico',                                                      
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
    
    
    /* === MOSTRAR/OCULTAR campos de acuerdo al tipo de portada === */   
     $('#select_tipo_portada').on('change', function (evt) {
       
       id_select = this.value;
       ///console.log(this.value);       
       //1= tipo imagen 
       if(id_select == 1 ) {
           
           $('#conten_imagen').removeClass('d-none');
           $('#conten_imagen').show();
           
           
           $('.conten_color').addClass('d-none');
           $('.conten_color').hide();
           
           //asterisco (*) campo importante 
           $('.conten_danger').addClass('d-none');
           $('.conten_danger').hide();
           
           //Remover validación a título si portada es de tipo Imagen
           $('#txt_titulo').rules("remove", "required");
           
            $('#foto_portada').rules("add", {
            required: true,
            messages: { 
                        required: ' Campo Requerido' ,
                      },
             });
             
           
           
       }
       //2= tipo Texto 
       else if (id_select ==2 ) {
           $('#conten_imagen').addClass('d-none');
           $('#conten_imagen').hide();
           
           $('.conten_color').removeClass('d-none');
           $('.conten_color').show();
           
           $('.conten_danger').removeClass('d-none');
           $('.conten_danger').show();
           
            
            //Agregar validación a título si portada es de tipo texto
            $('#txt_titulo').rules("add", {
            required: true,
            messages: { 
                        required: 'Campo Requerido',
                      },
             });
             
            $('#foto_portada').rules("remove", "required");
           
       }
       
   });
            

});