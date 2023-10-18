<? session_start();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../../estilos/myc_gral.css"/>

          <link type="text/css" rel="stylesheet" href="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
	<script type="text/javascript" src="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

  <title>Pegasus PRO</title>
</head>

<body>
<div id="contenedor">
  <?php require_once('..\includes\cabecera.php'); ?>
  <div id="contenido">
  	<h1>RECALCULAR TODOS LOS INDICADORES</h1>
 
              
       
        <br/>


            <form class="forma" action="formsubmipt.php" target="_blank" method="POST" name="parametros">
       
            <table class="tforma">
                <tr>
                    <td colspan="2">
                        <input class="btn"  type="submit" value="Recalcular"/>
                    </td>
                </tr>
            </table>
        </form>

  </div>
  <?php require_once('..\includes\piep.php'); ?>
</div>
</body>
</html>