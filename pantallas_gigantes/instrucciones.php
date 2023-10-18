<?php session_start();
		include("../clases/pantallas_gigantes.php");
		$pantallas_gigantes = new pantallas_gigantes();		
		$turnos = $pantallas_gigantes->contar_turnos_abiertos();
		$pantallas = ceil($turnos/8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="5; url=tiempo_real_maquinas.php" />
		<link rel="stylesheet" type="text/css" href="estilos/myc_treal.css"/>
		<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<?php
/*
			$vari=89;$vari2=900;
			echo"<script>
				var seccion = 1
				var tid = setInterval(traerDatos, 10000);
				function traerDatos() {
					seccion = seccion + 1;
				}
				
				$(document).ready(function() {
					$(\"#maquinas\").load(\"dash_board_maquinas.php?pantalla=\"+seccion);
					var refreshId = setInterval(function() {
						$(\"#maquinas\").load('dash_board_maquinas.php?pantalla='+seccion);
					}, 1000);
				});
				</script>"
*/
?>
		<title>Monitoreo y Control</title>
	</head>	
	<body bgcolor="#000000">
		<div id="contenedor">
			<table cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td id="maquinas">
						<div class="div2 verde">
							<div id="titulo">
								NOMBRE MAQUINA
							</div>
							<div id="datos">
								<div>
									OEE
								</div>
								<div class="unidverde">
									UNIDADES
								</div>
							</div>
							<div id="parada" class="noparo">
								0
							</div>	
						</div>
						<div class="div2 rojo">
							<div id="titulo">
								NOMBRE MAQUINA
							</div>
							<div id="datos">
								<div>
									OEE
								</div>
								<div class="unidrojo">
									UNIDADES
								</div>
							</div>
							<div id="parada">
								CAUSAL DE PARADA
							</div>	
						</div>
					</td>
				</tr>
				<tr>
					<td id="mensajes">
						<img src="imgs/6_blanco.png">
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>