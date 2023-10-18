<!--<link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css">-->

<div id="menuppal">
  <ul>
    <li><a href="/mic/tiempo_real.php"><img src="/mic/imgs/treal3.png" width="35" height="35"><br />Procesos en<br />Tiempo Real</a></li>
  <?   if($_SESSION["lvl"]>=2) echo "<li><a href=\"/mic/orden_produccion.php\"><img src=\"/mic/imgs/Orden.png\" width=\"35\" height=\"35\"><br />Ordenes de<br />Producci&oacute;n</a></li>"; ?>
    <li><a href="/mic/reportes/reportes.php"><img src="/mic/imgs/report1.png" width="35" height="35"><br />Reportes</a></li>
  <?   if($_SESSION["lvl"]>=2) echo "<li><a href=\"/mic/administrar_datos.php\"><img src=\"/mic/imgs/engrenages.png\" width=\"35\" height=\"35\"><br />Configuraci&oacute;n</a></li>"; ?>

  <?   if($_SESSION["lvl"]>=2) echo "
	<li><a href=\"/mic/detalle_turno/turnos.php\"><img src=\"/mic/imgs/batch.png\" width=\"35\" height=\"35\"><br />Detalle<br />de Batch</a></li>
    <li><a href=\"/mic/plantilla.php\"><img src=\"/mic/imgs/excel-xp.png\" width=\"35\" height=\"35\"><br />Data<br />IN / OUT</a></li>
    <li><a href=\"http://www.monitoreoycontrol.com.co/index.php?option=com_k2&view=item&layout=item&id=50&Itemid=137\" target=\"_blank\" onclick='return confirm(\"¿Seguro que desea contactar a soporte tecnico?\")'   ><img src=\"/mic/imgs/arroba_azul2.png\" width=\"40\" height=\"35\"><br />Contacto<br />de Soporte</a></li>
	<li><a href=\"/mic/progreso_ops/progreso_ops.php\"><img src=\"/mic/imgs/progress.png\" width=\"35\" height=\"35\"><br />Progreso<br />Ordenes</a></li>
	<li><a href=\"no_prodata\" target=\"_blank\"><img src=\"/mic/imgs/prodata.png\" width=\"56\" height=\"35\"><br />Pro Data<br />Collector</a></li>	
	<li><a href=\"/mic/no_pantalla.php\" target=\"_blank\"><img src=\"/mic/imgs/RTdisabled.jpg\" width=\"35\" height=\"35\"><br />Real<br />Time</a></li>
	"; 
	?>
  </ul>
</div>