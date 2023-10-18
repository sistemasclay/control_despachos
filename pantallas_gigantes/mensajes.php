<?php session_start();
		include("../clases/pantallas_gigantes.php");
		$pantallas_gigantes = new pantallas_gigantes();	
		$mensajes = $pantallas_gigantes->cargar_mensajes();
		$tiempo = $mensajes->fields['tiempo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="<?echo $tiempo;?>; url=mision.php" />
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
	<body bgcolor="#FFFFFF">
		<div id="contenedor">
		
			<table cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					
					<td class="mensaje">
						<p><? echo $mensajes->fields['titulo'];?></p>
<!--&#241;&aacute;-->
						<span><? echo $mensajes->fields['descripcion'];?></span>
					</td>
					<!--
					<td>
						&ensp;&ensp;&ensp;<img src="imgs/logoe.jpg">
					</td>
					-->
				</tr>
			</table>
		
		</div>
	</body>
</html>