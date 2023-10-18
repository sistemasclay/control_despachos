<?
include("../clases/reportes_excel_especial.php");
ini_set('memory_limit','1024M');
$repor= new reportes_excel();
$pagina="excel.php";

//echo $_POST["id_proceso"];

	if($_POST["fechai"] > $_POST["fechaf"])
	{
		echo "La fecha de inicio debe ser menor al fecha final";
		$_POST["tipo"]=100;
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
	}
	$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
	$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";
	
switch ($_POST["tipo"])
{
	case "1":
		$sql = "SELECT	t.id_turno turno, 
					p.nombre maquina, 
					pro.nombre_producto producto, 
					pe.nombre_persona operario,
					t.fecha_inicio fecha_i,
					t.fecha_fin fecha_f,
					t.unidades_conteo inyecciones,
					t.produccion_final produccion,
					t.indicador_4 oee
				FROM turnos t
					INNER JOIN procesos p ON t.id_proceso = p.id_proceso
					INNER JOIN productos pro ON pro.id_producto = t.id_producto
					INNER JOIN turno_asistencia ta ON ta.id_turno = t.id_turno AND ta.id_proceso = t.id_proceso
					INNER JOIN personal pe ON ta.id_empleado = pe.id_persona
				WHERE t.id_proceso = '".$_POST["id_proceso"]."'
					AND t.fecha_inicio<='".$_POST["fechaf"]."'
					AND t.fecha_inicio>='".$_POST["fechai"]."'
				ORDER BY pe.id_persona, t.fecha_inicio";
		$repor->excel_produccion_operario($sql,$_POST["id_proceso"]);
	break;
    
	case "2":
		$sql = "SELECT	t.id_turno turno, 
					p.nombre maquina, 
					pro.nombre_producto producto,
					pp.var2 var2,
					t.tiempo_turno tiempo
				FROM turnos t
					INNER JOIN procesos p ON t.id_proceso = p.id_proceso
					INNER JOIN productos pro ON pro.id_producto = t.id_producto
					INNER JOIN producto_proceso pp ON pp.id_proceso = p.id_proceso AND pp.id_producto = pro.id_producto
				WHERE t.id_proceso='".$_POST["id_proceso"]."'
					AND t.fecha_inicio<='".$_POST["fechaf"]."'
					AND t.fecha_inicio>='".$_POST["fechai"]."'
				ORDER BY p.id_proceso, t.id_turno";
		
		$repor->excel_consumo_energetico($sql,$_POST["id_proceso"]);
	break;
    
	case "3":
		$sql = "SELECT	t.id_turno turno, 
					p.nombre maquina, 
					pro.nombre_producto producto,
					t.dato_extra horario,
					t.unidades_conteo unidades,
					t.produccion_final produccion,
					t.indicador_4 oee,
					t.tiempo_turno tiempo
				FROM turnos t
					INNER JOIN procesos p ON t.id_proceso = p.id_proceso
					INNER JOIN productos pro ON pro.id_producto = t.id_producto
				WHERE t.id_proceso = '".$_POST["id_proceso"]."'
					AND t.fecha_inicio<='".$_POST["fechaf"]."'
					AND t.fecha_inicio>='".$_POST["fechai"]."'
				ORDER BY p.id_proceso, t.dato_extra, t.id_turno";
		$repor->excel_unidades_horario($sql,$_POST["id_proceso"]);
	break;
	
	case "4":
	
		$sql1 = "SELECT	coalesce(t.id_proceso, '0') proceso,
						sum(coalesce(t.tiempo_turno, '0')) tiempo_turno,
						sum(t.tiempo_maquina) tiempo_maquina,
						extract(month from t.fecha_inicio) mes,
						extract(day from t.fecha_inicio) dia
				FROM turnos t
					INNER JOIN procesos p ON t.id_proceso = p.id_proceso
					LEFT JOIN producto_proceso pp ON pp.id_proceso = p.id_proceso AND pp.id_producto = t.id_producto
				WHERE (t.fecha_inicio BETWEEN '".$_POST["fechai"]."' AND '".$_POST["fechaf"]."')
				GROUP BY proceso, mes, dia
				ORDER BY mes, dia";
		
		//De este SQL voy a obtener unicamente los nombres de las máquinas que aparecen entre las fechas seleccionadas
		$sql2 = "SELECT DISTINCT turnos.id_proceso maquina, procesos.nombre 
				FROM turnos 
					INNER JOIN procesos ON turnos.id_proceso = procesos.id_proceso 
				WHERE (fecha_inicio BETWEEN '".$_POST["fechai"]."' AND '".$_POST["fechaf"]."') 
				ORDER BY turnos.id_proceso";
		
		$repor->excel_horas_por_dia_maquina($sql1,$sql2,$_POST["fechai"],$_POST["fechaf"]);
	break;
}
?>

