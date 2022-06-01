<?php

  // --------------------------------------------------------------
    /**
     * Convierte un número entero , en uno de formato romano     
     * @param  $numero(int) , entero a transformar
     * @return  $num_romano(string) , Numero en romano
     */   
function numero_convertir_a_romano($number) {
	$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
   
}



?>