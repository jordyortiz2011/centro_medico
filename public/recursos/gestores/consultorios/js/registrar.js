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
    $('#form_registrar_consultorio').validate({
        
        /*  onfocusout: function(element) {
                                    this.element(element);
                            },  */
                                          
          //ignore: '.select2-input , .select2-focusser',
          
          rules: {
                    text_nombre: {
                        required: true,
                        maxlength: 100,
                    },
                      text_hora_inicio: {
                          required: true,
                      },
                    text_hora_fin: {
                          required: true,
                      },


                },    
        messages: {
                    text_cod_renaes: {
                        required: 'Campo Requerido',
                        maxlength: 'Máximo 100 caracteres permitidos',
                    },
                    text_hora_inicio: {
                        required: 'Campo Requerido',
                    },
                    text_hora_fin: {
                        required: 'Campo Requerido',
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
    $('#text_hora_inicio').datetimepicker();
    $('#text_hora_fin').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $("#text_hora_inicio").on("dp.change", function (e) {
        $('#text_hora_fin').data("DateTimePicker").minDate(e.date);
    });
    $("#text_hora_fin").on("dp.change", function (e) {
        $('#text_hora_inicio').data("DateTimePicker").maxDate(e.date);
    });
        
        
     
    
       
            

});