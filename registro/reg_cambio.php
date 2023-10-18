<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();


if($_GET["registro"]){$registro= $_GET["registro"];} else{ if($_POST["registro"]) {$registro= $_POST["registro"];} }

$info_registro = $logicaTurno->traer_registro_con_id($registro);

if($info_registro->fields["id_maquina"]){
	$tipo = 1;
	$proceso = $info_registro->fields["id_maquina"];
}
else{
	$tipo = 2;
	$proceso = $info_registro->fields["id_proveedor"];
}

$producto = $info_registro->fields["id_producto"];
$usuario = $info_registro->fields["id_usuario"];
$lote = $info_registro->fields["lote"];
$op = $info_registro->fields["orden_produccion"];

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
						<td class="boton2ON">
							INTERNO
						</td>
<?
						}
						else{
?>
						<td class="boton2OFF">
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
						<td class="boton2ON">
							EXTERNO
						</td>
<?
						}
						else{
?>
						<td class="boton2OFF">
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
							<input <?if($proceso){?>value="<?echo$proceso;?>"<?}?>list="procesos" name="procesos" id="id_proceso" class="caja_texto" readonly="true">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="boton3OFF">
							OK
						</td>
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
							<datalist id="productos">
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
							<input <?if($producto){?>value="<?echo$producto;?>"<?}?>list="productos" name="productos" id="id_producto" class="caja_texto" readonly="true">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="boton3OFF">
							OK
						</td>
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
							<input <?if($lote){?>value="<?echo$lote;?>"<?}?> name="lote" id="lote" type="text" class="caja_texto" readonly="true">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="boton3OFF">
							OK
						</td>
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
							<input <?if($op){?>value="<?echo$op;?>"<?}?> name="op" id="op" type="text" class="caja_texto" readonly="true">
						</td>
						<td class="blank1">
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
						<td class="boton3OFF">
							OK
						</td>
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
if($tipo && $proceso && $producto && $lote && $op){
									$usuarios = $logicaTurno->traer_usuarios();
									
									while(!$usuarios->EOF){
										echo '<option value="'.$usuarios->fields['id_persona'].'" label="'.$usuarios->fields['nombre_persona'].'"></option>';
										$usuarios->MoveNext();
									}
}
								?>
							</datalist>
							<input <?if($usuario){?>value="<?echo$usuario;?>"<?}?>list="usuarios" name="usuarios" class="caja_texto" id="id_usuario">
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
						<td class="botonGrabarON" onclick="cambiarUsuario()">
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
				<input type="hidden" name="registro" id="registro" value="<?echo $registro;?>"/>
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
	function cambiarUsuario(){
		var usuario = document.getElementById("id_usuario").value;
		var registro = document.getElementById("registro").value;
		var page = "formsubmit?seccion=reg_cambio&usuario=";
		var page = page.concat(usuario);
		var page = page.concat("&registro=");
		var page = page.concat(registro);
		//alert("Se va a cambiar el usuario");
		window.location.replace(page);
	}
</script>
</html>