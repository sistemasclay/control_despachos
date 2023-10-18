<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();
//$procesos_abiertos = $logicaTurno->listar_procesos_calidad_activos();

if($_GET["proceso"]){$proceso = $_GET["proceso"];} else{ if($_POST["proceso"]){$proceso = $_POST["proceso"];} }

if($_GET["producto"]){$producto = $_GET["producto"];} else{ if($_POST["producto"]) {$producto = $_POST["producto"]; } }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_reg_salir.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>Monitoreo y Control</title>
        <script>
<?php// echo "var proceso = " . $_REQUEST["proceso"] . ";"; ?>
<?php// echo "var numeroOperarios = " . $numeroOperarios . ";"; ?>
        </script>
    </head>
    <body>
			<div class="logos">
				<div class="logo1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div><div class="logo2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
			<div class="linea_divisora">.</div>
			<div class="titulos">
				<table class="tabla_titulos">
					<tr>
						<td class="espacio_blanco">.</td>
						<td class="boton">
							<a class="link" href="reg_abrir"><div class="text">ABRIR</div></a>
						</td>
						<td class="espacio_blanco">.</td>
					</tr>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="info">
				<table class="tabla_info">
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td colspan="3">
							Está seguro que desea cerrar este proceso de muestreos de este producto?
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>					
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="btn1" onclick="home()">
							NO
						</td>
						<td class="blank2">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td  class="btn2" onclick="cerrar()">
							SI
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="piep">
				<a href="http://172.16.96.55/mantenimiento/index.php"><div class="piep1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div></a><a href="http://172.16.96.203:809/mic/mic_central/seleccion_proceso.php"><div class="piep2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
    </body>
<script>
function home() {
	window.location.replace("reg_inicio");
}
function cerrar(){
	var proceso = document.getElementById("proceso").value;
	var producto = document.getElementById("producto").value;
	var page = "formsubmit?seccion=reg_salir&proceso=";
	var page = page.concat(proceso);
	var page = page.concat("&producto=");
	var page = page.concat(producto);
	window.location.replace(page);
}
</script>

</html>