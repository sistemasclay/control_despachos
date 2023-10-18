<?php
include("../../clases/reportes_excel.php");
$repor= new reportes_excel();
$pagina="exceltp.php";

//echo $_POST["id_proceso"];

if($_POST["opcion"]=="fecha")
{
	if($_POST["fechai"] > $_POST["fechaf"])
	{
		echo "La fecha de inicio debe ser menor al fecha final";
		$_POST["tipo"]=100;
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
	}
	$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
	$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";
}

switch ($_POST["tipo"])
{
	case "1":                                   
		$repor->excel_bitacoratp($_POST["fechai"],$_POST["fechaf"]);
	break;

	case "2":
		$repor->excel_asistenciatp($_POST["fechai"],$_POST["fechaf"]);
	break;

	case "3":
		$sql = "SELECT *
				FROM turnos as b 
					INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
					INNER JOIN productos as c ON (b.id_producto= c.id_producto)
				WHERE b.id_proceso='".$_POST["id_proceso"]."' AND fecha_inicio<='".$_POST["fechaf"]."' AND fecha_inicio>='".$_POST["fechai"]."' order by id_turno";

		$repor->excel_paradastp($_POST["fechai"],$_POST["fechaf"]);
	break; 
}
?>

