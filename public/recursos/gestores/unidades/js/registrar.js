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
    
    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_unidad').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    txt_nombre: {
                        required: true,
                        maxlength: 80,
                    },
                    txt_comentario: {
                      maxlength: 200,
                    },
                },    
        messages: {                        
                    txt_nombre: {
                        required: 'Ingrese un nombre',
                        maxlength: '80 caracteres máximo',
                    },
                    txt_comentario: {
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