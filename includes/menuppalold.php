<link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css">

<div id="menuppal">
  <ul>
     
    <li><a href="/mic/tiempo_real.php"><img src="/mic/imgs/treal.png" width="32" height="32"><br />Procesos en<br />Tiempo Real</a></li>
  <?   if($_SESSION["nivel"]>=2) echo "<li><a href=\"/mic/orden_produccion.php\"><img src=\"/mic/imgs/ordenes.png\" width=\"32\" height=\"32\"><br />Ordenes de<br />Producci&oacute;n</a></li>"; ?>
    <li><a href="/mic/reportes/reportes.php"><img src="/mic/imgs/reportes.png" width="32" height="32"><br />Reportes</a></li>
  <?   if($_SESSION["nivel"]>=2) echo "<li><a href=\"/mic/administrar_datos.php\"><img src=\"/mic/imgs/config.png\" width=\"32\" height=\"32\"><br />Configuraci&oacute;n</a></li>"; ?>

  <?   if($_SESSION["nivel"]>=2) echo "
      <li><a href=\"/mic/detalle_turno/turnos.php\"><img src=\"/mic/imgs/batch.png\" width=\"32\" height=\"32\"><br />Detalle<br />de Batch</a></li>
    <li><a href=\"/mic/plantilla.php\"><img src=\"/mic/imgs/excel.png\" width=\"32\" height=\"32\"><br />Importar<br />Excel</a></li>
    <li><a href=\"/mic/bakup.php\"><img src=\"/mic/imgs/bd.png\" width=\"32\" height=\"32\"><br />Base<br />de Datos</a></li>
    <li><a href=\"http://www.monitoreoycontrol.com.co/formulario_soporte\" target=\"_blank\" onclick='return confirm(\"¿Seguro que desea contactar a soporte tecnico?\")'   ><img src=\"/mic/imgs/contacto.png\" width=\"32\" height=\"32\"><br />Contacto<br />de Soporte</a></li>
	<li><a href=\"/mic/interfaz/interfaz.php\" target=\"_blank\"><img src=\"/mic/imgs/interfase.jpg\" width=\"32\" height=\"32\"><br />INTERFASE <br />IBES</a></li>"; ?>
    
  </ul>
</div>