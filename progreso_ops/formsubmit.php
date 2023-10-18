<?php
include("../clases/progreso_op_clase.php");
$repor= new progreso_op();
$pagina="progreso_ops.php";

if($_GET["tarea"])
{
$tarea = $_GET["tarea"];
//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
}
else
{
	if($_POST["tarea"])
	{
	$tarea = $_POST["tarea"];
	}
}

switch ($tarea){
	case 1:	
		if($_GET["fechai"])
		{
		$fechai = $_GET["fechai"];
		//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
		}
		else
		{
			if($_POST["fechai"])
			{
			$fechai = $_POST["fechai"];
			}
		}
		if($_GET["fechaf"])
		{
		$fechaf = $_GET["fechaf"];
		//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
		}
		else
		{
			if($_POST["fechaf"])
			{
			$fechaf = $_POST["fechaf"];
			}		
		}
		$repor->exportar_excel($fechai, $fechaf);
	break;
	
	case 2:
	
		if($_GET["orden"])
		{
		$orden = $_GET["orden"];
		//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
		}
		else
		{
			if($_POST["orden"])
			{
			$orden = $_POST["orden"];
			}
		}
		$repor->cerrar_orden($orden);
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	break;
}
?>

