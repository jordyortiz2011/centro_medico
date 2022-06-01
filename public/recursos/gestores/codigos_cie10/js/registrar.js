$(window).load(function () {
    // run code
    let codigo_cat = $('#select_categoria option:selected').attr('data-codigo');
    $('#text_codigo_tres').val(codigo_cat);
});

$(document).ready(function(){
            
     //REGISTRAR SELECT tipo colegio   
     $('.select2').select2({          
        allowClear: false , 
        minimumResultsForSearch: 7,      
    });



   // $('span.select2 > span').css('width','100%');

    $( ".numeric").numeric({
        negative: false ,   //true= con negativos; false= sin negativos
        decimal: false, //true= con decimales; false= sin decimales
       // altDecimal: "," ,   //la (,) como decimal alternativo, se cambiaran las comas por puntos
        //decimalPlaces: 2   //sólo se permite 2 decimales
    });

    //Modalidad de pago seleccionado
    $('#select_categoria').on('change', function (evt) {

        let codigo_cat = $('#select_categoria option:selected').attr('data-codigo');
        $('#text_codigo_tres').val(codigo_cat);
        //alert(codigo_cat);
    });



    /* Activar validación al cambiar select  */
    $('#select_categoria').on('change', function() {
        $(this).trigger('blur');
    });

    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_codigo').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    text_codigo: {
                        required: true,
                        //minlength: 1,
                        maxlength: 1,
                    },
                    text_descripcion: {
                      required: true,
                      minlength: 1,
                      maxlength: 60,
                    },
                    select_categoria: {
                      required: true,
                  },


                },    
        messages: {
                    text_codigo: {
                        required: 'Campo Requerido',
                        //minlength: 'Ingrese como mínimo 1 caracter',
                        maxlength: 'Ingrese como máximo 1 caracteres',
                    },
                    text_descripcion: {
                        required: 'Campo Requerido',
                        minlength: 'Ingrese como mínimo 1 caracter',
                        maxlength: 'Ingrese como máximo 60 caracter',
                    } ,
                    select_categoria: {
                        required: 'Seleccione opción',


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