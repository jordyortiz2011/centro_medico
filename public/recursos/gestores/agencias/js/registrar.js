$(document).ready(function(){    
            

    
    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_agencia').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    txt_nombre: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    }
                },
        messages: {                        
                    txt_nombre: {
                        required: 'Campo requerido',
                        minlength: '3 caracteres como mínimo',
                        maxlength: '100 caracteres máximo',
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