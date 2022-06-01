<?php

  // --------------------------------------------------------------
    /**
     * Transforma una fecha del sistema , en una fecha amigable     
     * @param  $fecha(date o string) , fecha en formato del sistema
     * @return  $fecha_legible(string) , fecha amigable Ejm: Lun 21 Mayo 2017 13:12:50
     */   
function fecha_transformar_fecha($fecha) {

        if ($fecha == null)
            return 'Sin Asignar';

         $mi_fecha = new DateTime("$fecha");
         $dia_semana =  $mi_fecha->format('w');
         $dia_fecha =  $mi_fecha->format('d');
         $mes_numero =  $mi_fecha->format('n');
         $anyo = $mi_fecha->format('Y');
         $horas_minutos = $mi_fecha->format('H:i:s'); //y segundos

        // echo "hoy es Mie $dia del $mes del $año $horas_minutos";

        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Ener","Febr","Marz","Abri","Mayo","Juni","Juli","Ago","Sept","Octu","Novi","Dici");

        $fecha_legible = $dias[$dia_semana]." ".$dia_fecha." ".$meses[($mes_numero-1)]. " $anyo - $horas_minutos" ;
        return $fecha_legible;
    }

function fecha_transformar_fecha_sin_hora($fecha) {

        if ($fecha == null)
            return 'Sin Asignar';

         $mi_fecha = new DateTime("$fecha");
         $dia_semana =  $mi_fecha->format('w');
         $dia_fecha =  $mi_fecha->format('d');
         $mes_numero =  $mi_fecha->format('n');
         $anyo = $mi_fecha->format('Y');
         $horas_minutos = $mi_fecha->format('H:i:s'); //y segundos

        // echo "hoy es Mie $dia del $mes del $año $horas_minutos";

        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Ener","Febr","Marz","Abri","Mayo","Juni","Juli","Ago","Sept","Octu","Novi","Dici");

        $fecha_legible = $dias[$dia_semana]." ".$dia_fecha." ".$meses[($mes_numero-1)]. " $anyo" ;
        return $fecha_legible;
    }

function fecha_transformar_fecha_sin_hora_completo($fecha) {

    if ($fecha == null)
        return 'Sin Asignar';

    $mi_fecha = new DateTime("$fecha");
    $dia_semana =  $mi_fecha->format('w');
    $dia_fecha =  $mi_fecha->format('d');
    $mes_numero =  $mi_fecha->format('n');
    $anyo = $mi_fecha->format('Y');
    $horas_minutos = $mi_fecha->format('H:i:s'); //y segundos

    // echo "hoy es Mie $dia del $mes del $año $horas_minutos";

    $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $fecha_legible = $dias[$dia_semana]." ".$dia_fecha." ".$meses[($mes_numero-1)]. " $anyo" ;
    return $fecha_legible;
}
    
 /* 
  * Obtiene el nombre de un mes, de acuerdo a su número correspondiente
  * (int)$num_mes: 1=Enero, 2=Febrero , etc
  * */   
 function fecha_obtener_nombre_mes($num_mes) {
 	  	
 	  switch ($num_mes) {
			   case 1:
				   $nomb_mes = 'Enero';
				   break;
		   		case 2:
				   $nomb_mes = 'Febrero';
				   break;
			   case 3:
				   $nomb_mes = 'Marzo';
				   break;	   
			   case 4:
				   $nomb_mes = 'Abril';
				   break;
		   		case 5:
				   $nomb_mes = 'Mayo';
				   break;
			   case 6:
				   $nomb_mes = 'Junio';
				   break;	
				case 7:
				   $nomb_mes = 'Julio';
				   break;
		   		case 8:
				   $nomb_mes = 'Agosto';
				   break;
			   case 9:
				   $nomb_mes = 'Setiembre';
				   break;	
				case 10:
				   $nomb_mes = 'Octubre';
				   break;
		   		case 11:
				   $nomb_mes = 'Noviembre';
				   break;
			   case 12:
				   $nomb_mes = 'Diciembre';
				   break;	
			   default:
				     $nomb_mes = 'Sin nombre';
				   break;
		   }
	  
	  return $nomb_mes;
 }

/*
 * Obtiene el nombre de un día abreviado del FullCalendar
 * (int)$dia mes: 0=Domingo 1=Lunes
 * */
function fecha_obtener_nombre_dia_abbr($num_dia) {

    switch ($num_dia) {
        case '[1]':
            $dia_abbr = 'Lun.';
            break;
        case '[2]':
            $dia_abbr = 'Mar.';
            break;
        case '[3]':
            $dia_abbr = 'Mie.';
            break;
        case '[4]':
            $dia_abbr = 'Jue.';
            break;
        case '[5]':
            $dia_abbr = 'Vie.';
            break;
        case '[6]':
            $dia_abbr = 'Sab.';
            break;
        case '[0]':
            $dia_abbr = 'Dom.';
            break;

        default:
            $dia_abbr = 'Sin nombre';
            break;
    }

    return $dia_abbr;
}


?>