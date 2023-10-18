<?php

// Declaro array a devolver.
$jsonData = array();

// Cargo lógica.
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();

switch ($_REQUEST["estado"]) {
    case 0:
        $jsonData['resultado'] = $logicaTurno->validarOperario(trim($_REQUEST["codigo"]));
        $jsonData['dato'] = $_REQUEST["codigo"];
        break;
    case 1:
        $jsonData['resultado'] = $logicaTurno->validarOP(trim($_REQUEST["codigo"]));
        $jsonData['dato'] = $_REQUEST["codigo"];
        break;
    case 2:
        $jsonData['resultado'] = $logicaTurno->validarProducto(trim($_REQUEST["codigo"]));
        $jsonData['dato'] = $_REQUEST["codigo"];
        break;
    case 3:
        //reponer
        $jsonData['resultado'] = $logicaTurno->traerDatosTurno(trim($_REQUEST["maquina"]));
        break;
    case 4:
        //iniciar
        $turno = json_decode(stripslashes(str_replace('\"', '"', $_REQUEST["turno"])),true);
        $jsonData['resultado']=$logicaTurno->iniciarTurno($turno);
        break;
    case 5:
        //traer datos conteo
        $jsonData['resultado'] = $logicaTurno->traerDatosTurno(trim($_REQUEST["maquina"]));
        break;
    case 6:
        //traer parada
        $jsonData['resultado'] = $logicaTurno->traerDatosParada(trim($_REQUEST["maquina"]));
        break;
    case 7:
        //registrar parada
        $jsonData['resultado'] = $logicaTurno->registrarParada(trim($_REQUEST["maquina"]),trim($_REQUEST["codigo"]));
        break;    
    case 8:
        //cerrar turno
        $turno = json_decode(stripslashes(str_replace('\"', '"', $_REQUEST["turno"])),true);        
        $jsonData['resultado'] = $logicaTurno->cerrarTurno($turno);
        break;       
    case 9:
        //guardar observaciones
        $turno = json_decode(stripslashes(str_replace('\"', '"', $_REQUEST["turno"])),true);        
        $jsonData['resultado'] = $logicaTurno->guardarObservaciones($turno);
        break;
    case 10:
        //traer etiquetas de desperdicios
        $turno = json_decode(stripslashes(str_replace('\"', '"', $_REQUEST["turno"])),true);        
        $jsonData['resultado'] = $logicaTurno->traerDatosDesperdicios($turno);
        break;
	case 11:
		//Sacar a una persona del turno
        $jsonData['resultado'] = $logicaTurno->sacarUsuario(trim($_REQUEST["usuario"]), trim($_REQUEST["maquina"]));
        break;
	case 12:
		//Ingresar a una persona al turno
        $jsonData['resultado'] = $logicaTurno->ingresarUsuario(trim($_REQUEST["usuario"]), trim($_REQUEST["maquina"]));
        break;
	case 13:
		//trer etiqueta datos turno
		$turno = json_decode(stripslashes(str_replace('\"', '"', $_REQUEST["turno"])),true);        
        $jsonData['resultado'] = $logicaTurno->traerDatoExtraTurno($turno);
		break;
}

// Imprimo array json.
//echo json_encode($jsonData);
echo json_encode($jsonData);


