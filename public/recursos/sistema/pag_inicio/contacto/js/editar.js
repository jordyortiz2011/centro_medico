$(document).ready(function(){    
            
    
    
    //Para ingresar sólo números en costo
    $( "#txt_telefono" ).numeric();
    
       
    
    
/*==================== VALIDACIONES ================================= */

    
  
         
     /* reglas/mensajes de validaciones */
    $('#form_contacto').validate({
        
         onfocusout: function(element) {
                                    this.element(element);
                            },                                        
          //ignore: '.select2-input , .select2-focusser',
          
            errorClass: 'has-danger',
          
          rules: {
                                    
                    txt_telefono: {
                        required: true, 
                        minlength: 6,                                                                                                                      
                    } ,
                    txt_direccion: {
                        required: true, 
                        maxlength: 250,                                                                                                                      
                    }  ,
                    txt_correo: {
                        required: true, 
                        email: true,                                                                                                                      
                    }                 
                },    
        messages: {                        
                    txt_telefono: {
                        required: 'Campo requerido', 
                        minlength: 'Ingrese 6 dígitoss',                                                                                                                      
                    },
                    txt_direccion: {
                        required: 'Campo requerido',  
                        maxlength: 'Ingrese menos de 250 caracteres',                                                                                                                      
                    }, 
                    txt_correo: {
                        required: 'Campo requerido',  
                        email: 'Ingrese un correo valido',                                                                                                                      
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
    
 
 
    
   
       
            

});