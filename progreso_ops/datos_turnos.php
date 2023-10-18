<? session_start(); ?>
<?
include("../clases/progreso_op_clase.php");
$datos = new progreso_op();

if($_POST["id_orden_produccion"])
{
    $orden_p = substr($_POST["id_orden_produccion"],2,-2);
}
else
{
    $orden_p = substr($_GET["id_orden_produccion"],2,-2);
}

$datos_orden = $datos->datos_op($orden_p);

$turnos = $datos->listar_turnos_op($orden_p);
$producto = $datos->producto_orden($orden_p);
$fecha_inicio = $datos_orden->fields["fecha_inicio"];
$fecha_fin = $datos->fecha_ultimo_turno($orden_p);
$indicadores_op = $datos->tiempos_indicadores_op($orden_p);
$asistencia = $datos->asistencia_op($orden_p);
$etiquetas = $datos->listar_etiquetas();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css"/>
  <title>Pegasus PRO</title>
</head>

<body>
<div id="contenedor">
	<?php require_once('..\includes\cabecera.php'); ?>
	<div id="contenido">
		<h1>Detalles de la Orden</h1>
		<form action="formsubmit.php" method="post">
		<table class="tinfo">
			<tr >
				<th colspan="2"><? echo "Detalles de Batchs de la Orden:  ".$orden_p; ?></th>
			</tr>
			<tr class="impar">
				<td colspan="2">
					<? echo "Producto: ".$producto->fields["id_producto"]." - ".$producto->fields["nombre_producto"]; ?>
				</td>
			</tr>
            <tr class="par">
				<td>
					<? echo "Fecha Inicio: ".$fecha_inicio; ?>
				</td>
				<td>
					<? echo "Fecha Fin: ".$fecha_fin; ?>
				</td>
			</tr>
		</table>


<br/>
<h1>Tiempos y Indicadores</h1>
		<table class="tinfo">
			<tr>
				<th>Tiempos</th>
				<th>Indicadores</th>
				<th>Produccion</th>
			</tr>

			<tr class="impar">
				<td><? echo "Tiempo Total Parada: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_total_paro']);  ?></td>
				<td><? echo $etiquetas[0]['etiqueta'].": ".$indicadores_op->fields['indicador_1']; ?></td>
				<td><? echo "Unidades:  ".$indicadores_op->fields['unidades_conteo']; ?></td>
			</tr>

			<tr class="par">
				<td><? echo "Tiempo Parada Prog: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_paro_prog']);  ?></td>
				<td><? echo $etiquetas[1]['etiqueta'].": ".$indicadores_op->fields['indicador_2']; ?></td>
				<td><? echo "Produccion Final: "; ?>
					<input class="ctxt" type="text" name="pfinal" id="pfinal" value="<? echo $indicadores_op->fields['produccion_final'];  ?>" />
				</td>
			</tr>

			<tr class="impar">
				<td><? echo "T. Paradas NO Prog: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_paro_no_p']);  ?></td>
				<td><? echo $etiquetas[2]['etiqueta'].": ".$indicadores_op->fields['indicador_3']; ?></td>
				<td><? echo $etiquetas[12]['etiqueta'].": "; ?>
					<input class="ctxt" type="text" name="d1" id="d1" value="<? echo $indicadores_op->fields['desperdicio_1'];  ?>" />
				</td>
				
			</tr>
	
			<tr class="par">
				<td><? echo "Parada Averias: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_paro_g1']);  ?></td>
				<td><? echo $etiquetas[3]['etiqueta'].": ".$indicadores_op->fields['indicador_4']; ?></td>
				<td><? echo $etiquetas[13]['etiqueta'].": "; ?>
					<input class="ctxt" type="text" name="d2" id="d2" value="<? echo $indicadores_op->fields['desperdicio_2'];  ?>" />
				</td>
			</tr>
			
			<tr class="impar">
				<td><? echo "P Cuadres y Ajustes: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_paro_g2']);  ?></td>
				<td><? echo $etiquetas[4]['etiqueta'].": ".$indicadores_op->fields['indicador_5']; ?></td>
				<td><? echo $etiquetas[14]['etiqueta'].": "; ?>
					<input class="ctxt" type="text" name="d3" id="d3" value="<? echo $indicadores_op->fields['desperdicio_3'];  ?>" />
				</td>
			</tr>
			
			<tr class="par">
				<td><? echo "Pequenas Paradas: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_paro_g3']);  ?></td>
				<td><? echo $etiquetas[5]['etiqueta'].": ".$indicadores_op->fields['indicador_6']; ?></td>
				<td ></td>
			</tr>

			<tr class="impar">
				<td><? echo "Tiempo Estandar: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_std_prog']);  ?></td>
				<td><? echo $etiquetas[6]['etiqueta'].": ".$indicadores_op->fields['indicador_7']; ?></td>
				<td></td>
			</tr>

			<tr class="par">
				<td><? echo "Tiempo Hombre: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_hombre']);  ?></td>
				<td></td>
				<td></td>
			</tr>

			<tr class="impar">
				<td><? echo "Tiempo Maquina: ".$datos->tiempo_segundos($indicadores_op->fields['tiempo_maquina']);  ?></td>
				<td></td>
				<td></td>
			</tr>

      </table>

</form> 
<br/>

<h1>Grupo De Trabajo</h1>

	<table class="tinfo">
		<tr>
			<th>Turno</th>
			<th>Maquina</th>
			<th>Empleado</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
<?//		<th>Tiempo</th>   ?>
		</tr>
		<?
			$color=array('impar','par');
			$c_estilo=0;
			while (!$asistencia->EOF) {
				if($c_estilo%2!=0)
                    echo '<tr class="'.$color[0].'">';
				else
                    echo '<tr class="'.$color[1].'">';
              
				echo "<td>".$asistencia->fields["id_turno"]."</td>";
				echo "<td>".$asistencia->fields["id_proceso"]."</td>";
				echo "<td>".$asistencia->fields["id_empleado"]."-".$asistencia->fields["nombre_persona"]."</td>";
				echo "<td>".$asistencia->fields["fecha_inicio"]."</td>";
				echo "<td>".$asistencia->fields["fecha_fin"]."</td>";
//				echo "<td>".$datos->tiempo_segundos($asistencia->fields["tiempo_hombre"])."</td>";
				echo "</tr>";
				$c_estilo++;
				$asistencia->MoveNext();
			}
		?>
      </table>

  </div>
  <?php require_once('..\includes\piep.php'); ?>
</div>
</body>
</html>
