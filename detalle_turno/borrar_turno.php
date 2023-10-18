<? session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="estilos/myc_gral.css"/>



  <title>Monitoreo y Control</title>
</head>

<body>
<div id="contenedor">
  <?php require_once('..\includes\cabecera.php'); ?>
  <div id="contenido">
  	

        <?php
        // put your code here
        echo "<h1>!SE DISPONE A ELIMINAR EL TURNO: ".$_GET["turno"]." DEL PROCESO: ".$_GET["id_proceso"]."
           <br/>  LOS DATOS SE ELIMINARAN DE FORMA PERMANENTE!<br/><br/>   ¿ESTA SEGURO DE ELIMINAR ESTE BATCH?</h1>";
        ?>
        <form class="forma" id="feliminar" name="feliminar" method="post" action="formsubmit.php">
<input type="hidden" name="seccion" id="seccion" value="eliminar_turno"/>
<input type="hidden" value="<? echo $_GET["id_proceso"] ?>" name="proceso"/>
<input type="hidden" value="<? echo $_GET["turno"] ?>" name="turno"/>

  <table class="tforma">
      <tr>
          <td>
          <input class="btn" type="submit" name="Submit" value="ELIMINAR" />
          </td>
      </tr>
  </table>

        </form>
  </div>
  <?php require_once('..\includes\piep.php'); ?>
</div>
</body>
</html>