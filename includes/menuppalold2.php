<link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css">

<div id="menuppal">
  <ul>
     
    <li><a href="/mic/tiempo_real.php"><img src="/mic/imgs/treal.png" width="25" height="25"><br />Procesos en<br />Tiempo Real</a></li>
  <?   if($_SESSION["nivel"]>=2) echo "<li><a href=\"/mic/orden_produccion.php\"><img src=\"/mic/imgs/ordenes.png\" width=\"25\" height=\"25\"><br />Ordenes de<br />Producci&oacute;n</a></li>"; ?>
    <li><a href="/mic/reportes/reportes.php"><img src="/mic/imgs/reportes.png" width="25" height="25"><br />Reportes</a></li>
  <?   if($_SESSION["nivel"]>=2) echo "<li><a href=\"/mic/administrar_datos.php\"><img src=\"/mic/imgs/config.png\" width=\"25\" height=\"25\"><br />Configuraci&oacute;n</a></li>"; ?>

  <?   if($_SESSION["nivel"]>=2) echo "
      <li><a href=\"/mic/detalle_turno/turnos.php\"><img src=\"/mic/imgs/batch.png\" width=\"25\" height=\"25\"><br />Detalle<br />de Batch</a></li>
    <li><a href=\"/mic/plantilla.php\"><img src=\"/mic/imgs/excel.png\" width=\"25\" height=\"25\"><br />Importar<br />Excel</a></li>
    <li><a href=\"/mic/bakup.php\"><img src=\"/mic/imgs/bd.png\" width=\"25\" height=\"25\"><br />Base<br />de Datos</a></li>
    <li><a href=\"http://www.monitoreoycontrol.com.co/formulario_soporte\" target=\"_blank\" onclick='return confirm(\"¿Seguro que desea contactar a soporte tecnico?\")'   ><img src=\"/mic/imgs/contacto.png\" width=\"25\" height=\"25\"><br />Contacto<br />de Soporte</a></li>
	<li><a href=\"http://192.168.1.34/mic_manual/login.aspx\" target=\"_blank\"><img src=\"/mic/imgs/prodata.png\" width=\"40\" height=\"25\"><br />Pro Data<br />Collector</a></li>
	<li><a href=\"/mic/progreso_ops/progreso_ops.php\"><img src=\"/mic/imgs/progreso.png\" width=\"25\" height=\"25\"><br />Progreso<br />Ordenes</a></li>
	"; 
	?>
  </ul>
</div>