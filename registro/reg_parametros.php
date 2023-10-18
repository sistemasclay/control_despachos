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
        <link rel="stylesheet" type="text/css" href="css/styles_reg_parametros.css"/>
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
						<td class="espacio_blanco1">.</td>
						<td>
							<div class="text1"><?echo $info_producto->fields["nombre_producto"];?></div>
						</td>
						<td class="espacio_blanco1">.</td>
						<td>
							<div class="text2">
<?
							if($tipo == 1){
								echo $info_proceso->fields["nombre"];
							}
							else if($tipo == 2){
								echo $info_proveedor->fields["nombre_proveedor"];
							}
?>
							</div>
						</td>
						<td class="espacio_blanco1">.</td>
					</tr>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="info">
				<form method="post" action="formsubmit.php">
					<input type="hidden" name="seccion" id="seccion" value="reg_parametros"/>
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
$estandares = $logicaTurno->traer_parametros_producto($producto);
//echo $estandares;
while(!$estandares->EOF){
	echo	'<tr>
				<th colspan="6">
					'.$estandares->fields["nombre_parametro"].'
				</th>
			</tr>';
	echo	'<tr>	
				<td colspan="4">
					<input class="ctxt" name="params[]" type="number" id="'.$estandares->fields["id_parametro"].'" onkeypress="return valida(event,'.$estandares->fields["id_parametro"].')" onchange="validar_datos('.$estandares->fields["id_parametro"].')" step="any"/>
				</td>
				<td>
					'.$estandares->fields["unidad_medida"].'
				</td>
				<td id="valid'.$estandares->fields["id_parametro"].'">
					<img src="css/imagenes/cuadro.png" WIDTH=35 HEIGHT=35 BORDER=0>
				</td>
			</tr>';
	echo	'<tr style="display: none;" id="msj'.$estandares->fields["id_parametro"].'">
				<td id="txt'.$estandares->fields["id_parametro"].'" colspan="5">
					¡Dato por fuera de los estandares!
				</td>
				<td>
					<img src="css/imagenes/cuadro.png" WIDTH=35 HEIGHT=35 BORDER=0>
				</td>
			</tr>';
	$estandares->MoveNext();
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
		window.location.replace("reg_inicio");
	}
function valida(e,parametro){
	// capturamos la tecla pulsada
	var teclaPulsada=window.event ? window.event.keyCode:e.which;

	// capturamos el contenido del input
	var valor=document.getElementById(parametro).value;

	// 45 = tecla simbolo menos (-)
	// Si el usuario pulsa la tecla menos, y no se ha pulsado anteriormente
	// Modificamos el contenido del mismo añadiendo el simbolo menos al
	// inicio
	if(teclaPulsada==45 && valor.indexOf("-")==-1)
	{
		document.getElementById(parametro).value="-"+valor;
	}

	// 13 = tecla enter
	// 46 = tecla punto (.)
	// Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
	// punto
	if(teclaPulsada==13 || (teclaPulsada==46 && valor.indexOf(".")==-1))
	{
		return true;
	}

	// devolvemos true o false dependiendo de si es numerico o no
	return /\d/.test(String.fromCharCode(teclaPulsada));
}
function validar_datos(parametro) {
	var valor = document.getElementById(parametro).value;
	var producto = document.getElementById("producto").value;
	var validar = "valid";
	var validar = validar.concat(parametro);
	var mensaje = "msj";
	var mensaje = mensaje.concat(parametro);
	var text = "txt";
	var text = text.concat(parametro);
	/*alert(validar);*/
    $.ajax({
        url: "turno.php",
        type: "post",
        data: {estado: '1',
            producto: producto,
			parametro: parametro,
			valor: valor},
        datatype: 'json',
        success: function (data) {
			res = JSON.parse(data);
			if (res.resultado == 1 || res.resultado == 2) {
				document.getElementById(validar).className = "mal";
				document.getElementById(text).innerHTML = 'Valor por debajo de los estandares';
				document.getElementById(mensaje).style.display = 'table-row';
			}
			else if (res.resultado == 3 || res.resultado == 4) {
				document.getElementById(validar).className = "mal";
				document.getElementById(text).innerHTML = 'Valor por encima de los estandares';
				document.getElementById(mensaje).style.display = 'table-row';
				
			} else {
				document.getElementById(validar).className = "bien";
				document.getElementById(mensaje).style.display = 'none';
			}
        },
        error: function () {
            //alert('error al validar!');
        }
    });
}
</script>
</html>