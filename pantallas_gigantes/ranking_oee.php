<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
	<!--	<meta http-equiv="refresh" content="3">-->
	<meta http-equiv="refresh" content="10; url=msg1.php" />
		<link rel="stylesheet" type="text/css" href="estilos/myc_treal.css"/>
		<script type="text/javascript" src="../jquery/jquery.min.js"></script>
		<?php //3000
			$vari=89;$vari2=900;
			echo	"<script>
				$(document).ready(function() {
					
				$(\"#ranking\").load(\"dash_board_ranking.php\");
					
						var refreshId = setInterval(function() {
				$(\"#ranking\").load('dash_board_ranking.php?valoralazar='+ Math.random()+'&var=".$vari."');
				}, 1000);
				
				});
				</script>"
		?>
		<title>Monitoreo y Control</title>
	</head>
	
	<body bgcolor="#000000">
		<div id="contenedor">
			<table cellpadding="0" cellspacing="0" height="100%" width="100%">
			<tr>
				<td class="titulo">
				<?
					echo 'RANKING   OEE </br>';
				?>
				</td>
			</tr>
			<tr>
				<td class="ranking" id="ranking">
				</td>
			</tr>
			<tr>
				<td id="mensajes">
					<img src="imgs/6_blanco.png">
				</td>
			</tr>
		</div>
	</body>

</html>