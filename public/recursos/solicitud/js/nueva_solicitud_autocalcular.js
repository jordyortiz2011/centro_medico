$(document).ready(function () {

    /* ************************************************************** */
    /* ============= DIVERSIFICACIÓN DE CULTIVO  =======================*/

    $("table#tabla_cultivo").on("keyup change", 'input[name$="[ha_produccion]"], input[name$="[produccion]"] ,  input[name$="[precio]"] ', function (event) {

        //calcular el resultado de:  ha_producción * producción * precio
        calculateRow_cultivo($(this).closest("tr"));

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_cultivo();
    });

    function calculateRow_cultivo(row) {

        var ha_produccion   = +row.find('input[name$="[ha_produccion]"]').val();
        var produccion      = +row.find('input[name$="[produccion]"]').val();
        var precio          = +row.find('input[name$="[precio]"]').val();

        if( isNaN(ha_produccion) )
            ha_produccion = 0;
        if( isNaN(produccion) )
            produccion = 0;
        if( isNaN(precio) )
            precio = 0;

        var subTotal = ha_produccion *  produccion * precio ;

        //SubTotal de cada fila de la tabla "Cultivo"
        row.find('input[name$="[total]"]').val(subTotal.toFixed(2));
    }

    //Sumatoria de todos los subtotales  de CULTIVO
    function calculateTotal_sumatoria_cultivo() {
        var grandTotal = 0;
        $("table#tabla_cultivo").find('input[name$="[total]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#total_sumatoria_cultivo").html(grandTotal.toFixed(2));
    }


	
});//fin document
