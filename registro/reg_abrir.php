<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();

if($_GET["tipo"]){$tipo = $_GET["tipo"];} else{ if($_POST["tipo"]){$tipo = $_POST["tipo"];} }

if($_GET["proceso"]){$proceso = $_GET["proceso"];} else{ if($_POST["proceso"]){$proceso = $_POST["proceso"];} }

if($_GET["producto"]){$producto = $_GET["producto"];} else{ if($_POST["producto"]) {$producto = $_POST["producto"]; } }

if($_GET["usuario"]){$usuario = $_GET["usuario"];} else{ if($_POST["usuario"]){$usuario = $_POST["usuario"];} }

if($_GET["lote"]){$lote = $_GET["lote"];} else{ if($_POST["lote"]){$lote = $_POST["lote"];} }

if($_GET["op"]){$op = $_GET["op"];} else{ if($_POST["op"]){$op = $_POST["op"];} }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_reg_abrir.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>Control de Calidad</title>
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
						<td class="boton1">
							<div class="text">ABRIR</div>
						</td>
						<td class="espacio_blanco">.</td>
					</tr>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="info">
				</br>
				<table class="tabla_tipo">
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
						if($tipo == 1){
?>
						<td class="boton2ON" onclick="cargarProcesos()">
							INTERNO
						</td>
<?
						}
						else{
?>
						<td class="boton2OFF" onclick="cargarProcesos()">
							INTERNO
						</td>
<?
						}
?>
						<td class="blank2">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
						if($tipo == 2){
?>
						<td class="boton2ON" onclick="cargarImportados()">
							EXTERNO
						</td>
<?
						}
						else{
?>
						<td class="boton2OFF" onclick="cargarImportados()">
							EXTERNO
						</td>
<?
						}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
				</table>
				</br>
				<table class="tabla_datos">
					<input type="hidden" name="tipo" id="tipo" value="<?echo $tipo?>"/>
					<!-- Procesos -->
					<tr>
						<td colspan="5">
							PROCESO
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="información">
							<datalist id="procesos" >
								<?
if($tipo){
									if($tipo == 1){
										$maquinas = $logicaTurno->traer_maquinas();
									}
									else if($tipo == 2){
										$proveedores = $logicaTurno->traer_proveedores();
									}
									if($maquinas){
										while(!$maquinas->EOF){
										echo '<option value="'.$maquinas->fields['id_proceso'].'" label="'.$maquinas->fields['nombre'].'"></option>';
										$maquinas->MoveNext();
										}
									}
									else if($proveedores){
										while(!$proveedores->EOF){
										echo '<option value="'.$proveedores->fields['id_proveedor'].'" label="'.$proveedores->fields['nombre_proveedor'].'"></option>';
										$proveedores->MoveNext();
										}
									}
}
								?>
							</datalist>
							<input <?if($proceso){?>value="<?echo$proceso;?>"<?}?>list="procesos" name="procesos" id="id_proceso" class="caja_texto">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
if($tipo){
?>
						<td class="boton3ON" onclick="cargarDatos()">
							OK
						</td>
<?
}
else{
?>
						<td class="boton3OFF">
							OK
						</td>
<?
}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
					<!-- Productos -->
					<tr>
						<td colspan="5">
							PRODUCTO
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="información">
							<datalist id="productos" >
								<?
if($tipo && $proceso){
									if($tipo == 1){
										$productos = $logicaTurno->traer_productos_maquina($proceso);
									}
									else if($tipo == 2){
										$productos = $logicaTurno->traer_productos_proveedor($proceso);
									}
									
									while(!$productos->EOF){
										echo '<option value="'.$productos->fields['id_producto'].'" label="'.$productos->fields['nombre_producto'].'"></option>';
										$productos->MoveNext();
									
									}
}
								?>
							</datalist>
							<input <?if($producto){?>value="<?echo$producto;?>"<?}?>list="productos" name="productos" id="id_producto" class="caja_texto">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
if($tipo && $proceso){
?>
						<td class="boton3ON" onclick="cargarDatos()">
							OK
						</td>
<?
}
else{
?>
						<td class="boton3OFF">
							OK
						</td>
<?
}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
						<!-- Lote -->
					<tr>
						<td colspan="5">
							LOTE
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="información">
							<input <?if($lote){?>value="<?echo$lote;?>"<?}?> name="lote" id="lote" type="text" class="caja_texto">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
if($tipo && $proceso && $producto){
?>
						<td class="boton3ON" onclick="cargarDatos()">
							OK
						</td>
<?
}
else{
?>
						<td class="boton3OFF">
							OK
						</td>
<?
}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
						<!-- Orden Produccion -->
					<tr>
						<td colspan="5">
							ORDEN PRODUCCI&Oacute;N
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="información">
							<input <?if($op){?>value="<?echo$op;?>"<?}?> name="op" id="op" type="text" class="caja_texto">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
if($tipo && $proceso && $producto && $lote){
?>
						<td class="boton3ON" onclick="cargarDatos()">
							OK
						</td>
<?
}
else{
?>
						<td class="boton3OFF">
							OK
						</td>
<?
}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
					<!-- Usuarios -->
					<tr>
						<td colspan="5">
							USUARIO
						</td>
					</tr>
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="información">
							<datalist id="usuarios" >
								<?
if($tipo && $proceso && $producto){
									$usuarios = $logicaTurno->traer_usuarios();
									
									while(!$usuarios->EOF){
										echo '<option value="'.$usuarios->fields['id_persona'].'" label="'.$usuarios->fields['nombre_persona'].'"></option>';
										$usuarios->MoveNext();
									}
}
								?>
							</datalist>
							<input <?if($usuario){?>value="<?echo$usuario;?>"<?}?>list="usuarios" name="usuarios" id="id_usuario" class="caja_texto">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
if($tipo && $proceso && $producto && $lote && $op){
?>
						<td class="boton3ON" onclick="cargarDatos()">
							OK
						</td>
<?
}
else{
?>
						<td class="boton3OFF">
							OK
						</td>
<?
}
?>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
				</table>
				</br>
				<table class="tabla_tipo">
					<tr>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="botonCancel" onclick="atras()">
							CANCELAR
						</td>
						<td class="blank2">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
<?
	//SI YA SE ALMACENARON LOS DATOS ENTONCES ACTIVAR
if($tipo && $proceso && $producto && $usuario && $lote && $op){
?> 
						<td class="botonGrabarON" onclick="abrirTurno()">
							ABRIR
						</td>
<?
}
	//NO ACTIVAR SI NO SE HAN CARGADO TODOS LOS DATOS
else{
?>
						<td class="botonGrabarOFF">
							ABRIR
						</td>
<?
}
?>
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
	function atras() {
		window.location.replace("reg_inicio");
	}
	function cargarProcesos() {
		window.location.replace("reg_abrir?tipo=1");
	}
	function cargarImportados() {
		window.location.replace("reg_abrir?tipo=2");
	}
	function cargarDatos(){
		var tipo = document.getElementById("tipo").value;
		var proceso = document.getElementById("id_proceso").value;
		var producto = document.getElementById("id_producto").value;
		var usuario = document.getElementById("id_usuario").value;
		var lote = document.getElementById("lote").value;
		var op = document.getElementById("op").value;
		var page = "reg_abrir?tipo=";
		var page = page.concat(tipo);
		var page = page.concat("&proceso=");
		var page = page.concat(proceso);
		var page = page.concat("&producto=");
		var page = page.concat(producto);
		var page = page.concat("&usuario=");
		var page = page.concat(usuario);
		var page = page.concat("&lote=");
		var page = page.concat(lote);
		var page = page.concat("&op=");
		var page = page.concat(op);
		window.location.replace(page);
	}
	function abrirTurno(){
		var tipo = document.getElementById("tipo").value;
		var proceso = document.getElementById("id_proceso").value;
		var producto = document.getElementById("id_producto").value;
		var usuario = document.getElementById("id_usuario").value;
		var lote = document.getElementById("lote").value;
		var op = document.getElementById("op").value;
		var page = "formsubmit?seccion=reg_abrir&tipo=";
		var page = page.concat(tipo);
		var page = page.concat("&proceso=");
		var page = page.concat(proceso);
		var page = page.concat("&producto=");
		var page = page.concat(producto);
		var page = page.concat("&usuario=");
		var page = page.concat(usuario);
		var page = page.concat("&lote=");
		var page = page.concat(lote);
		var page = page.concat("&op=");
		var page = page.concat(op);
		//alert("Se a abierto un nuevo turno");
		window.location.replace(page);
	}
</script>
</html>