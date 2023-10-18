<?php
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
$objPHPExcel = $objReader->load("plantilla_op.xls");


//leer las ops

$objPHPExcel->setActiveSheetIndex(1);//ops
$leer_siguiente=1;
$filas_excel=3;
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
		$ops["id_op"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
		$ops["id_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
		$ops["id_proceso"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
		$ops["fecha_ini"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
		$ops["fecha_fin"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
		$ops["cantidad"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5,$filas_excel)->getValue();
		$ops["max_dias"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6,$filas_excel)->getValue();
		$ops["porc_ref"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7,$filas_excel)->getValue();
		$filas_excel++;
		$indice_array++;
	}
}
//print_r($plantas);


//inserter plantas
$registros= count($ops["id_op"]);
$i=0;
echo "Registrando Ordenes de produccion..<br>";
for($i=0;$i<$registros;$i++)
{
    if($datos->comprobar_op($ops["id_op"][$i]))
    {
    $datos->actualizar_op($ops["id_op"][$i],$ops["id_proceso"][$i],$ops["id_producto"][$i],($ops["cantidad"][$i]+1),$ops["fecha_ini"][$i],$ops["fecha_fin"][$i],"on",$ops["max_dias"][$i],$ops["porc_ref"][$i]);
    }
    else
    {
    $datos->registro_op($ops["id_op"][$i],$ops["id_proceso"][$i],$ops["id_producto"][$i],($ops["cantidad"][$i]+1),$ops["fecha_ini"][$i],$ops["fecha_fin"][$i],"on",$ops["max_dias"][$i],$ops["porc_ref"][$i]);
    }
}
echo "Registrando Ordenes de produccion..<br>";

//---------------------------

       $pagina="../orden_produccion.php";
       echo "la Informacion fue cargada a la base de datos con exito.";
       echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
?>


