$(document).ready(function(){

    //Activará el select del departamento, si se seleccionó el tipo de usuario trabajador
    $('#select_tipo_usuario ').on('change', function (evt) {

        let id_tipo =  $('#select_tipo_usuario option:selected').val();

        //alert(id_tipo); return;

        //Usuario tipo Técnico, activar departamento
        //8 = Gerente ; 7=Analista ; 4=Analista de negocio ; 3=Articulador
        if( id_tipo == 8  || id_tipo == 7 || id_tipo == 4 || id_tipo == 3 ){


            $('#select_agencias').removeClass('no_validar');

            $('#contenedor_agencia').show();

        }else {


            $('#select_agencias').addClass('no_validar');

            $('#contenedor_agencia').hide();
        }




    });

});