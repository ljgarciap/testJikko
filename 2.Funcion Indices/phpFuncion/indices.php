<?php
function encontrarIndices($numeros, $objetivo) {
    $BR = (php_sapi_name() == 'cli') ? "\n" : "<br>";

    foreach ($numeros as $indiceActual => $num) {
        //echo "Array Original: [" . implode(", ", $numeros) . "]" . $BR;
        $complemento = $objetivo - $num;
        $tempNumeros = $numeros;
        //echo "Buscando complemento para $num: $complemento" . $BR;
        unset($tempNumeros[$indiceActual]);
        //echo "Array temporal para búsqueda: [" . implode(", ", $tempNumeros) . "]" . $BR;
        
        if (in_array($complemento, $tempNumeros)) {
            $indiceComplemento = array_search($complemento, $tempNumeros);
            //echo "Indice 1: $indiceActual, Indice 2: $indiceComplemento" . $BR;
            return [$indiceActual, $indiceComplemento];
        }
    }
    return null;
}

$BRE = (php_sapi_name() == 'cli') ? "\n" : "<br>";

$numeros = [1, 4, 5, 4, 8];
$objetivo = 8;
$resultado = encontrarIndices($numeros, $objetivo);

echo "-----------------------------------------" . $BRE;
echo "Array de búsqueda: [" . implode(", ", $numeros) . "]" . $BRE;
echo "-----------------------------------------" . $BRE;

if ($resultado) {
    echo "Indices encontrados: [" . implode(", ", $resultado) . "]";
} else {
    echo "No se encontraron números que sumen $objetivo";
}
?>