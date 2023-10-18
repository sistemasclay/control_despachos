<?php
include("../clases/progreso_op_clase.php");
$repor= new progreso_op();
$pagina="progreso_ops.php";

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
$repor->exportar_excel($fechai, $fechaf)
?>

