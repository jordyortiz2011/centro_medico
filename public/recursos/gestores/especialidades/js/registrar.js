$(document).ready(function(){    
            
     //REGISTRAR SELECT tipo colegio   
     $('.select2').select2({          
        allowClear: false , 
        minimumResultsForSearch: 7,      
    });

    //para registrar nuevo
    if( $('#text_color').val() == '' ) {
        //para color
        $('#div_color').colorpicker({
            color: '#378fb8',
            format: 'hex'
        });
    }
    //para editar
    else {
        $('#div_color').colorpicker({
            //color: '#378fb8',
            format: 'hex'
        });
    }

    
    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_especialidad').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    text_nombre: {
                        required: true,
                        maxlength: 100,
                    },
                  text_color: {
                      required: true  ,
                  },
                    text_descripcion: {
                      //required: true,
                      maxlength: 200,
                    },
                },    
        messages: {
                    text_cod_renaes: {
                        required: 'Campo Requerido',
                        maxlength: 'Máximo 100 caracteres permitidos',
                    },
                    text_color: {
                        required: 'Campo Requerido',
                    },
                    text_descripcion: {
                        //required: 'Campo Requerido',
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