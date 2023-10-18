<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();

if($_GET["tipo"]){$tipo = $_GET["tipo"];} else{ if($_POST["tipo"]){$tipo = $_POST["tipo"];} }

if($_GET["proceso"]){$proceso = $_GET["proceso"];} else{ if($_POST["proceso"]){$proceso = $_POST["proceso"];} }

if($_GET["producto"]){$producto = $_GET["producto"];} else{ if($_POST["producto"]) {$producto = $_POST["producto"]; } }

if($_GET["usuario"]){$usuario = $_GET["usuario"];} else{ if($_POST["usuario"]){$usuario = $_POST["usuario"];} }

if($_GET["lote"]){$lote = $_GET["lote"];} else{ if($_POST["lote"]){$lote = $_POST["lote"];} }

if($_GET["op"]){$op = $_GET["op"];} else{ if($_POST["op"]){$op = $_POST["op"];} }

if($tipo == 1){
	$info_proceso = $logicaTurno->traer_info_maquina($proceso);
}
else if($tipo == 2){
	$info_proveedor = $logicaTurno->traer_info_proveedor($proceso);
}

$info_producto = $logicaTurno->traer_info_producto($producto);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_reg_fallos.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>Control de Calidad</title>
        <script>
<?php// echo "var proceso = " . $_REQUEST["proceso"] . ";"; ?>
<?php// echo "var numeroOperarios = " . $numeroOperarios . ";"; ?>
        </script>
    </head>
    <body >
			<div class="logos">
				<div class="logo1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div><div class="logo2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
			<div class="linea_divisora">.</div>
			<div class="titulos">
				<table class="tabla_titulos">
					<tr>
						<td class="espacio_blanco1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></td>
						<td>
							<div class="text1">DEFECTO</div>
						</td>
						<td class="espacio_blanco1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></td>
						<td>
							<div class="text1">ESTADO</div>
						</td>
						<td class="espacio_blanco1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></td>
					</tr>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="info">
				<form method="post" action="formsubmit.php">
					<input type="hidden" name="seccion" id="seccion" value="reg_fallos"/>
					<input type="hidden" name="tipo" id="tipo" value="<?echo $tipo;?>"/>
					<input type="hidden" name="proceso" id="proceso" value="<?echo $proceso;?>"/>
					<input type="hidden" name="producto" id="producto" value="<?echo $producto;?>"/>
					<input type="hidden" name="usuario" id="usuario" value="<?echo $usuario;?>"/>
					<input type="hidden" name="lote" id="lote" value="<?echo $lote;?>"/>
					<input type="hidden" name="op" id="op" value="<?echo $op;?>"/>
					<table class="tabla_info">
						<tr>
							<td class="espacio_blanco2">
								<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
							</td>
							<td class="parametro">
								<table class="tabla_parametro">
<?
$fallos = $logicaTurno->traer_fallos_producto($producto);
//echo $fallos;
while(!$fallos->EOF){
	echo	'<tr>	
				<td colspan="4">
					'.$fallos->fields["nombre_fallo"].'
				</td>
				<td>
					<input class="ctxt" name="fallos[]" type="checkbox" value="'.$fallos->fields["id_fallo"].'" onclick="validar_datos(this,'.$fallos->fields["id_fallo"].')"/>
				</td>
				<td id="valid'.$fallos->fields["id_fallo"].'" class="bien">
					<img src="css/imagenes/cuadro.png" WIDTH=35 HEIGHT=35 BORDER=0>
				</td>
			</tr>';
	echo	'<tr style="display: none;" id="msj'.$fallos->fields["id_fallo"].'">
				<td  colspan="6" id="msjtext'.$fallos->fields["id_fallo"].'">';
		if($fallos->fields["criticidad"]==1){ echo 'Critico'; } else if($fallos->fields["criticidad"]==2){ echo'Mayor'; }else{ echo 'Menor'; }
	echo		'</td>
			</tr>';
	$fallos->MoveNext();
}


?>
								</table>
							</td>
							<td class="espacio_blanco2">
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
							<td class="botonOK">
								<input class="btn" type="submit" name="Submit" value="OK" />
							</td>
							<td class="blank1">
								<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="linea_divisora">.</div>
			<div class="piep">
				<a href="http://172.16.96.55/mantenimiento/index.php"><div class="piep1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div></a><a href="http://172.16.96.203:809/mic/mic_central/seleccion_proceso.php"><div class="piep2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
    </body>
<script>

function atras() {
	window.location.replace("reg_parametros");
}

function validar_datos(check,id) {
	var validar = "valid";
	var validar = validar.concat(id);
	var msj = "msj";
	var msj = msj.concat(id);
	var msjtext = "msjtext";
	var msjtext = msjtext.concat(id);
	/*alert(check.checked);*/
	if(check.checked){
		document.getElementById(validar).className = "mal";
		document.getElementById(msj).style.display = 'table-row';
		//document.getElementById(msjtext).innerHTML = "Error";
	}
	else{
		document.getElementById(validar).className = "bien";
		document.getElementById(msj).style.display = 'none';
		//document.getElementById(msjtext).innerHTML = "";
	}
	
}
</script>
</html>