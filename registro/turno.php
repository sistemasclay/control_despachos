<?php

// Declaro array a devolver.
$jsonData = array();

// Cargo lógica.
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();

switch ($_REQUEST["estado"]) {
    case 1:
		//etiqueta con un check o con una X dependiendo si el dato esta entre los promedios o no
        $jsonData['resultado'] = $logicaTurno->comprobar_valor_parametro_producto(trim($_REQUEST["producto"]), trim($_REQUEST["parametro"]), trim($_REQUEST["valor"]));
        $jsonData['dato'] = $_REQUEST["parametro"];
        break;
}

// Imprimo array json.
//echo json_encode($jsonData);
echo json_encode($jsonData);


