<?php
session_start(); 

ini_set('memory_limit','1024M');

include("clases/exportar_datos.php");
$repor= new exportar_datos();

$action = $_POST["actionButton"];
//echo '<script type="text/javascript">alert("Acaba cargar la pantalla");</script>';
	/** Error reporting */
	error_reporting(E_ALL);
	
	/** PHPExcel */
	require_once 'clases/PHPExcel.php';
	
	/** PHPExcel_IOFactory */
	require_once 'clases/PHPExcel/IOFactory.php';
	


$ok=0;

if($action=="Import")
{


echo "<h1>Importar archivo</h1>";
//datos del arhivo
$nombre_archivo ="plantilla/".$HTTP_POST_FILES['path']['name'];
$tipo_archivo = $HTTP_POST_FILES['path']['type'];
echo "<h1>".$HTTP_POST_FILES['path']['name']."</h1>";
$tamano_archivo = $HTTP_POST_FILES['path']['size'];

//compruebo si las características del archivo son las que deseo
	if (!(($HTTP_POST_FILES['path']['name']=="despachos.xls"))) {
		echo "<h1>La extensión o el tamaño de los archivos no es correcta.</h1> <br><br><table><tr><td><li>Se permiten archivos .xls<br></td></tr></table>";
	}else{
		if (move_uploaded_file($HTTP_POST_FILES['path']['tmp_name'], $nombre_archivo)){
		echo "<h1>El archivo ha sido cargado correctamente.</h1>";
		$ok=1;
		$pagina="plantilla/datos_excel.php";
		echo "<meta http-equiv=\"refresh\" target=\"_blank\" content=\"2;URL=".$pagina."\">";
		}else{
		echo "<h1>Ocurrió algún error al subir el fichero. No pudo guardarse.</h1>";
		echo "</br><h1>".$HTTP_POST_FILES['path']['tmp_name']."</h1>";
		echo "</br><h1>".$nombre_archivo."</h1>";
		}
	}

}
else
{   if($action=="Export")
    {
		echo '<script type="text/javascript">alert("Presionó el boton de exportar");</script>';
		/*$repor->exportar_excel();
		echo "<h1>Exportar archivo</h1>";*/
    }
}

if($ok!=1)
{
?>

			<div id="titulo">
				<h1>CARGUE LA REMISION</h1>
			</div>
                <!--div principal-->
                <!--  overflow: scroll; -->
			<div id="contenido">
				<div id="plantilla" class="scrollstyle">
					<form class="forma" id="dataForm" name="dataForm" method="post" enctype="multipart/form-data" action="principal?seccion=plantilla">
						<table class="tforma">
							<tr>
								<td>
									<input   type="file" name="path" id="path" style="width:300px"/>
								</td>
								<td>
<input class="btn" type="submit" value="Import" name="actionButton" id="actionButton" />
<!--<input class="btn" type="image" src="imgs/import1.png" alt="Importar" width="61" height="81" value="Import" name="actionButton" id="actionButton" title="Importar" />-->
<!--<input class="btn" type="image" src="imgs/export1.png" alt="Exportar" width="61" height="81" value="Export" name="actionButton" id="actionButton" title="Exportar" />-->
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
<?

}

?>