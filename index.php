<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="estilos/myc_gral.css"/>

  <script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>

  <title>Control de Despachos</title>
</head>

<body>
<div id="contenedor">
  <?php require_once('includes/cabecera.php'); ?>
  <div id="pantalla">

      <?                    if($_SESSION["id_usuario"])
                    {
						$pagina="principal.php";
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                    }
                    else
                        {
          ?>
		  
		<h1>INGRESO DE USUARIO</h1>
		<form action="form_submit_login.php" method="post">
			<table align="center" width="20%" height="150" class="tforma">
				<tr>
					<td class="etq">
						Usuario:
					</td>
					<td>
						<input class="ctxt" name="usuario" type="text" id="usuario" />
					</td>
				</tr>
				<tr>
					<td class="etq">
						Contraseña:
					</td>
					<td>
						<input class="ctxt" name="pass" type="password" id="pass" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center">
							<input class="btn"  type="submit" name="Submit" value="Enviar" />
						</div>
					</td>
				</tr>
		   </table>
	   </form>
<? } ?>
  </div>
  <?php require_once('includes/piep.php'); ?>
</div>


    <script  languaje= "JavaScript" >

var f1 = new LiveValidation('usuario');
f1.add( Validate.Presence );
f1.add( Validate.Numericality, { onlyInteger: true } );

var f2 = new LiveValidation('pass');
f2.add( Validate.Presence );
</script>
</body>
</html>