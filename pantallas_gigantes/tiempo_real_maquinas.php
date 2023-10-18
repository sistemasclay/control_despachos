<?php session_start();
		include("../clases/pantallas_gigantes.php");
		$pantallas_gigantes = new pantallas_gigantes();		
		$turnos = $pantallas_gigantes->contar_turnos_abiertos();
		$pantallas = ceil($turnos/8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="<?echo ($pantallas*10);?>; url=ranking_oee.php" />
		<link rel="stylesheet" type="text/css" href="estilos/myc_treal.css"/>
		<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<?php
			$vari=89;$vari2=900;
			echo"<script>
				var seccion = 1
				var dato = 0
				var tid = setInterval(traerDatos, 10000);
				var intervalo = setInterval(traerDatos2, 5000);
				var col = setInterval(alternarColor, 100);
				var color = 0;
				function traerDatos() {
					seccion = seccion + 1;
					dato = -1;
				}
				function traerDatos2() {
					dato = dato + 1;
				}
				function alternarColor() {
					if(color == 0){
						color = 1;
					}
					else{
						color = 0;
					}
				}
				$(document).ready(function() {
					$(\"#maquinasfull\").load(\"dash_board_maquinas.php?pantalla=\"+seccion+\"&&dato=\"+dato+\"&&colour=\"+color);
					var refreshId = setInterval(function() {
						$(\"#maquinasfull\").load('dash_board_maquinas.php?pantalla='+seccion+\"&&dato=\"+dato+\"&&colour=\"+color);
					}, 100);
				});
				</script>"
?>
		<title>Monitoreo y Control</title>
	</head>	
	<!--<body bgcolor="#000000"  onload="setInterval('Blink()',500)">-->
	<body bgcolor="#000000">
		<div id="contenedor">
			<table cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td id="maquinasfull">
					</td>
				</tr>
				
		</div>
	</body>
</html>