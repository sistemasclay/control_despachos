<?php
 session_start();
ini_set('memory_limit','1024M');
include("../clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once '../clases/PHPExcel.php';

/** PHPExcel_IOFactory */
require_once '../clases/PHPExcel/IOFactory.php';
require_once '../clases/PHPExcel/Reader/Excel5.php';

$objReader = new PHPExcel_Reader_Excel5();
//$objPHPExcel = $objReader->load("Planilla BD Clay VERSION 10.0.xls");
$objPHPExcel = $objReader->load("despachos.xls");


//leer el remision

$objPHPExcel->setActiveSheetIndex(0);//remision
$leer_siguiente=1;
$filas_excel=2;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
	$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
	if($valor_celda=="")
	{
		$leer_siguiente=0;
	}
	else
	{
		$remision["id_remision"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
		$remision["cliente_remision"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
		$remision["id_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
		$remision["cantidad_p"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
		$remision["lote_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6,$filas_excel)->getValue();


		// Antes
		// $remision["id_remision"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
		// $remision["cliente_remision"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7,$filas_excel)->getValue();
		// $remision["id_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8,$filas_excel)->getValue();
		// $remision["cantidad_p"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9,$filas_excel)->getValue();
		// $remision["lote_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21,$filas_excel)->getValue();
		$filas_excel++;
		$indice_array++;
	}
}
//insertar remision
$registros= count($remision["id_producto"]);
$i=0;
$datos->registro_despacho($_SESSION["id_usuario"]);
$codigo_despacho = $datos->traer_ultimo_despacho();
echo "Registrando despacho..<br>";
$remision_actual = '';
for($i=0;$i<$registros;$i++)
{
	//1. SE VERIFICA QUE LA REMISION QUE SE ESTÁ INTENTANDO AGREGAR NO HAYA SIDO TERMINADA
	if(!$datos->comprobar_remision_terminada($remision["id_remision"][$i])){
		
		//2. VERIFICAR SI LA REMISION YA FUE ASIGNADA AL DESPACHO SI YA LO ESTA, NO HACE NADA, SI NO, ENTONCES LA ASIGNA AL DESPACHO
		if($remision_actual != $remision["id_remision"][$i]){
			//se registra una nueva remision
			$remision_actual = $remision["id_remision"][$i];
			if(!$datos->comprobar_remision_despacho($codigo_despacho, $remision_actual)){//SI NO SE A ASIGNADO LA REMISION A UN DESPACHO... ¡ASIGNELA!
				$datos->asignar_remision_a_despacho($codigo_despacho, $remision_actual,$remision["cliente_remision"][$i]);
			}
		}
		
		//3. ACTUALIZAR O INGRESAR LA REMISION EN EL SISTEMA 
		if($datos->comprobar_remision_solicitud($remision_actual,$remision["id_producto"][$i]))
		{
			$datos->actualizar_remision_solicitud($remision_actual,$remision["id_producto"][$i],$remision["cantidad_p"][$i],$remision["lote_producto"][$i]);
		}
		else
		{
			$datos->registro_remision_solicitud($remision_actual,$remision["id_producto"][$i],$remision["cantidad_p"][$i],$remision["lote_producto"][$i]);
		}
		
	}
	
}
echo "Registrando despacho...<br>";

       $pagina="../principal?seccion=despacho&id_despacho=$codigo_despacho";
       echo "la Informacion fue cargada a la base de datos con exito.";
       echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
?>

