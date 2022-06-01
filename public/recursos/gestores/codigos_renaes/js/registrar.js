$(document).ready(function(){    
            
     //REGISTRAR SELECT tipo colegio   
     $('.select2').select2({          
        allowClear: false , 
        minimumResultsForSearch: 7,      
    });
     /* Activar validación al cambiar select  */
    $('#select_cole_tipo').on('change', function() {
        $(this).trigger('blur');        
    });
   // $('span.select2 > span').css('width','100%');

    $( ".numeric").numeric({
        negative: false ,   //true= con negativos; false= sin negativos
        decimal: false, //true= con decimales; false= sin decimales
       // altDecimal: "," ,   //la (,) como decimal alternativo, se cambiaran las comas por puntos
        //decimalPlaces: 2   //sólo se permite 2 decimales
    });
    
    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_renae').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    text_cod_renaes: {
                        required: true,
                        maxlength: 4,
                    },
                    text_micro: {
                      required: true,
                      maxlength: 200,
                    },
                },    
        messages: {
                    text_cod_renaes: {
                        required: 'Campo Requerido',
                        maxlength: 'Número máximo 9999',
                    },
            text_micro: {
                        required: 'Campo Requerido',
                        maxlength: 'Sólo 200 caracteres permitido',
                                                     
                    } 
                                         
                },
        highlight: function (element) {
                        //console.log(element);                      
                                    
                        $(element).parent().parent().addClass('has-danger');                       
                  },
        unhighlight: function (element, errorClass, validClass) {
                        $(element).parent().parent().removeClass('has-danger');
          },
                    
       /* success: function (element) {           
                         $(element).parent().parent().removeClass('has-danger');                       
            },   */                 
        errorPlacement: function (error, element) {                              
                         error.insertAfter(element.parent());                            
                        },                               
    });
        
        
     
    
       
            

});