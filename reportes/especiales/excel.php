<? session_start(); ?>
<?
$fecha = time();
include("../../clases/reportes.php");
$repor= new reportes();
//$datos = new configuracion_aplicacion();
$procesos = $repor->listar_procesos_activos();
$etiquetas=$repor->listar_etiquetas();
//echo $etiquetas[0]["etiqueta"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../../estilos/myc_gral.css"/>

          <link type="text/css" rel="stylesheet" href="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
	<script type="text/javascript" src="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

  <title>Pegasus PRO</title>
</head>

<body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
	<div id="contenedor">
		<?php require_once('..\..\includes\cabecera.php'); ?>
		<div id="contenido">
			<h1>REPORTES EXCEL</h1>
			<form class="forma"  action="excel.php" method="POST" name="procesos">
				<br/>
				<h1> SELECCIONE UN PROCESO</h1>
				<table class="tforma">
					<tr>
						<td class="etq">
							PROCESO:
						</td>
						<td>
							<select class="lista" name="proceso" id="proceso">
<?
								while (!$procesos->EOF) {
echo "<option class=\"oplista\" value=\" ".$procesos->fields['id_proceso']." \">".$procesos->fields['nombre']."</option>";
									$procesos->MoveNext();
								}
?>
							</select>
						</td>
						<td colspan="2">
							<input class="btn" type="submit" value="buscar"/>
						</td>
					</tr>
<!--					
					<tr>
						<td colspan="3">
							<a href="exceltp.php" >Todos los procesos</a>
						</td>
					</tr>
-->
				</table>
			</form>
			<br/>
			<br/>
<?
			if($_POST["proceso"])
			{
				$turnos = $repor->listar_turnos_maquina($_POST["proceso"]);
				// print_r($turnos->fields);
				$maquina =  $repor->detalle_proceso($_POST["proceso"]);
				echo "<H1>TURNOS DEL PROCESO  : ".$_POST["proceso"]." - ".$maquina->fields['nombre']."</H1>";
        ?>

				<form class="forma" action="formsubmit.php" target="_blank" method="POST" name="parametros">
					<input type="hidden" value="<? echo $_POST["proceso"] ?>" name="id_proceso"/>
					<table class="tforma">
						<tr>
							<td class="etq">
								
							</td>
							<td class="etq">
								DESDE
							</td>
							<td class="etq">
								HASTA
							</td>
						</tr>
<!--
						<tr>
							<td class="etq">
								<input  type="radio" name="opcion" value="turno" checked/> Por Turno
								<br/>
							</td>
							<td>
								<select class="lista" name="tini" id="tini">
<?/*
								while (!$turnos->EOF) {
echo "<option class=\"oplista\" value=\" ".$turnos->fields['id_turno']." \">".$turnos->fields['id_turno']."</option>";
									$turnos->MoveNext();
								}
*/?>
								</select>
							</td>
							<td>
								<select class="lista"  name="tfin" id="tfin">
<?/*
									$turnos->MoveFirst();
									while (!$turnos->EOF) {
echo "<option class=\"oplista\" value=\" ".$turnos->fields['id_turno']." \">".$turnos->fields['id_turno']."</option>";
										$turnos->MoveNext();
									}
*/?>
								</select>
							</td>
						</tr>
-->
						<tr>
							<!--<td class="etq"><input type="radio" name="opcion" value="fecha" checked/> Por Fecha<br/></td>-->
							<td class="etq">
								Fecha
							</td>
							<td>
								<input class="ctxt" type="text" name="fechai" id="fechai" onclick="displayCalendar(document.forms[1].fechai,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"/>
							</td>
							<td>
								<input class="ctxt" type="text" name="fechaf" id="fechaf" onclick="displayCalendar(document.forms[1].fechaf,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"  />
							</td>
						</tr>
						<tr>
							<td class="etq">
								Seleccione un reporte
							</td>
							<td colspan="2">
								<select class="lista" size="1" name="tipo" id="tipo">
								<option value="1" >Reporte de Produccion por Operario</option>
								<option value="2" >Reporte de Consumo Energetico</option>
								<option value="3" >Reporte de Produccion por Horarios</option>
								<option value="4" >Reporte de Horas Diarias por máquina</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input class="btn"  type="submit" value="Ver Reporte"/>
							</td>
						</tr>
					</table>
				</form>
<?
            }
            else
            {
				echo "<H1>Debe seleccionar un proceso</H1>";
            }
        // put your code here
?>
  </div>
  <?php require_once('..\..\includes\piep.php'); ?>
</div>
</body>
</html>