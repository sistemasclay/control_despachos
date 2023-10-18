<? session_start();
/*
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();
*/


$pagina = 'principal';
//echo $pagina;
if($_GET["seccion"])
{
	$seccion = $_GET["seccion"];
	//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
}
else
{
	if($_POST["seccion"])
	{
		$seccion = $_POST["seccion"];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="estilos/myc_gral.css"/>
	<script type="text/javascript" src="jquery/jquery-3.1.1.min.js"></script>
	<link type="text/css" rel="stylesheet" href="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
	<script type="text/javascript" src="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>


<!-- DataTable -->
<!-- <script type="text/javascript" src="jquery/dataTables.jqueryui.min.js"></script> -->



<!-- Si -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
 -->
<!-- Prueba -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/b-1.6.5/b-html5-1.6.5/sb-1.0.1/sp-1.2.2/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/b-1.6.5/b-html5-1.6.5/sb-1.0.1/sp-1.2.2/datatables.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/b-1.6.5/b-html5-1.6.5/fh-3.1.7/sb-1.0.1/sp-1.2.2/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/b-1.6.5/b-html5-1.6.5/fh-3.1.7/sb-1.0.1/sp-1.2.2/datatables.min.js"></script> -->


	<title>Control de Despachos</title>
</head>

<body>

<audio id="error">
	<source src="audio/error.mp3"></source>
	<source src="audio/error.wav"></source>
	<source src="audio/error.ogg"></source>
</audio>

<audio id="correct">
	<source src="audio/correct.mp3"></source>
	<source src="audio/correct.wav"></source>
	<source src="audio/correct.ogg"></source>
</audio>

<div id="contenedor">
	<?require_once('includes/cabecera.php'); ?>
	<div id="pantalla">
		<table class="tmenu">
			<tr>
				<td class="menu">
					<table>
						<tr>
							<td align="center">
								<a href="http://181.49.12.218:84" target="_blank"><IMG class="btn_guardar" SRC="imgs/cctv.jpg" ALT="CCTV" onmouseover="src='imgs/cctv.jpg'" onMouseOut="src='imgs/cctv.jpg'" onclick="resirigir()" width="100" height="100"></a>
							</td>
						</tr>
<?
						if($_SESSION["nivel"]==3){
?>
						<tr>
							<td class="menuitem">
<?
								echo '<a href="'.$pagina.'?seccion=usuarios"><IMG SRC="imgs/1.png" ALT="USUARIOS" onmouseover="src=\'imgs/1A.png\'" onMouseOut="src=\'imgs/1.png\'" ></a>';
?>
							</td>
						</tr>

						<?
						}if($_SESSION["nivel"]>=3){
?>
						<tr>
							<td class="menuitem">
<?
								echo '<a href="'.$pagina.'?seccion=despachos"><IMG SRC="imgs/2.png" ALT="DESPACHOS" onmouseover="src=\'imgs/2A.png\'" onMouseOut="src=\'imgs/2.png\'" ></a>';
?>
							</td>
						</tr>
<?						/*<tr>
							<td class="menuitem">

								echo '<a href="'.$pagina.'?seccion=lotes"><IMG SRC="imgs/7.png" ALT="LOTES" onmouseover="src=\'imgs/7A.png\'" onMouseOut="src=\'imgs/7.png\'" ></a>';

							</td>
						</tr>*/
?>
<?
						}
						if($_SESSION["nivel"]==2 || $_SESSION["nivel"]==3){
?>
						<tr>
							<td class="menuitem">
<?
								echo '<a href="'.$pagina.'?seccion=productos"><IMG SRC="imgs/5.png" ALT="PRODUCTOS" onmouseover="src=\'imgs/5A.png\'" onMouseOut="src=\'imgs/5.png\'" ></a>';
?>
							</td>
						</tr>
<?
						}
						if($seccion=='remisionm'){
?>
							<tr>
								<td align="center">
									<IMG class="btn_guardar" SRC="imgs/3.png" ALT="Guardar" onmouseover="src='imgs/3A.png'" onMouseOut="src='imgs/3.png'" onclick="accion()">
								</td>
							</tr>
<?
						}
?>
					</table>
				</td>
				<td class="pantalla">
<?
						switch ($seccion)
						{
							
							case 'usuarios':
								require_once('usuarios.php');
							break;
							case 'despacho':
								require_once('despacho.php');
							break;
							case 'remision':
								require_once('remision.php');
							break;
							case 'despachos':
								require_once('despachosporfecha.php');
							break;
							case 'plantilla':
								require_once('plantilla.php');
							break;
							case 'productos':
								require_once('productos.php');
							break;
							case 'lotes':
								require_once('lotes.php');
							break;
							case 'despachos_historico':
								require_once('despachohistorico.php');
							break;
							case 'despachosporfecha':
							require_once('despachosporfecha.php');
							break;
							case 'reporte':
								require_once('reporte.php');
							break;
							default:
								echo '<h1> HOLA '.$_SESSION["nombre"].' ¿QUE DESEAS HACER? </h1>';
						}
?>
				</td>
			</tr>
		</table>
	</div>
	<?php require_once('includes/piep.php'); ?>
</div>
</body>
</html>