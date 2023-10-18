<?php
include("../../clases/reportes_excel.php");
$repor= new reportes_excel();
$pagina="excel.php";

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

if($_POST["opcion"]=="turno")
{
	if($_POST["tini"] > $_POST["tfin"])
	{
		echo "El Batch de inicio debe ser menor al Batch final";
		$_POST["tipo"]=100;
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";                    
	}
	if($_POST["tini"]=="")
	{
		echo "Debe seleccionar interbalo de Batchs";
		$_POST["tipo"]=100;
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
	}
	if($_POST["tfin"]=="")
	{
		echo "Debe seleccionar interbalo de Batchs";
		$_POST["tipo"]=100;
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
	}
}
        
switch ($_POST["tipo"])
{
	case "1":
		if($_POST["opcion"]=="turno")
		{
		$sql = "SELECT *, b.id_proceso
			FROM turnos as b 
				INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
				INNER JOIN productos as c ON (b.id_producto= c.id_producto)
				LEFT JOIN producto_proceso pp ON (a.id_proceso = pp.id_proceso and c.id_producto = pp.id_producto)
			WHERE b.id_proceso='".$_POST["id_proceso"]."' 
				AND id_turno<='".$_POST["tfin"]."' 
				AND id_turno>='".$_POST["tini"]."' 
			ORDER BY id_turno";
		}
		else
		{
			if($_POST["opcion"]=="fecha")
			{
				$sql = "SELECT *, b.id_proceso
					FROM turnos as b 
						INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
						INNER JOIN productos as c ON (b.id_producto= c.id_producto)
						LEFT JOIN producto_proceso pp ON (a.id_proceso = pp.id_proceso and c.id_producto = pp.id_producto)
					WHERE b.id_proceso='".$_POST["id_proceso"]."' 
						AND fecha_inicio<='".$_POST["fechaf"]."' 
						AND fecha_inicio>='".$_POST["fechai"]."' 
					ORDER BY id_turno";
			}
		}
		$repor->excel_bitacora($sql);
	break;
    
	case "2":
		if($_POST["opcion"]=="turno")
		{
		$sql = "SELECT *
				FROM turnos as b 
					INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
					INNER JOIN productos as c ON (b.id_producto= c.id_producto)
				WHERE b.id_proceso='".$_POST["id_proceso"]."' 
					AND id_turno<='".$_POST["tfin"]."' 
					AND id_turno>='".$_POST["tini"]."' 
				ORDER BY id_turno";
		}
		else
		{
			if($_POST["opcion"]=="fecha")
			{
				$sql = "SELECT *
						FROM turnos as b 
							INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
							INNER JOIN productos as c ON (b.id_producto= c.id_producto)
						WHERE b.id_proceso='".$_POST["id_proceso"]."' 
							AND fecha_inicio<='".$_POST["fechaf"]."' 
							AND fecha_inicio>='".$_POST["fechai"]."' 
						ORDER BY id_turno";
			}
		}
		$repor->excel_asistencia($sql,$_POST["id_proceso"]);
	break;
    
	case "3":
		if($_POST["opcion"]=="turno")
		{
			$sql = "SELECT *
					FROM turnos as b 
						INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
						INNER JOIN productos as c ON (b.id_producto= c.id_producto)
					WHERE b.id_proceso='".$_POST["id_proceso"]."' 
						AND id_turno<='".$_POST["tfin"]."' 
						AND id_turno>='".$_POST["tini"]."' 
					ORDER BY id_turno";
		}
		else
		{
			if($_POST["opcion"]=="fecha")
			{
				$sql = "SELECT *
						FROM turnos as b 
							INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) 
							INNER JOIN productos as c ON (b.id_producto= c.id_producto)
						WHERE b.id_proceso='".$_POST["id_proceso"]."' 
							AND fecha_inicio<='".$_POST["fechaf"]."' 
							AND fecha_inicio>='".$_POST["fechai"]."' 
						ORDER BY id_turno";
			}
		}
		$repor->excel_paradas($sql,$_POST["id_proceso"]);
	break;
}
?>

