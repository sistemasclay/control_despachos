<? session_start(); ?>
<?
$action  = $_POST["actionButton"];
        /** Error reporting */
    error_reporting(E_ALL);

    /** PHPExcel */
    require_once 'clases/PHPExcel.php';

    /** PHPExcel_IOFactory */
    require_once 'clases/PHPExcel/IOFactory.php';

$ok=0;

if($action=="Import")
{
	echo "Importar archivo";
	//datos del arhivo
	$nombre_archivo ="plantilla_ops/".$HTTP_POST_FILES['path']['name'];
	$tipo_archivo = $HTTP_POST_FILES['path']['type'];
	echo $HTTP_POST_FILES['path']['name'];
	$tamano_archivo = $HTTP_POST_FILES['path']['size'];
	
	//compruebo si las características del archivo son las que deseo
	if (!(($HTTP_POST_FILES['path']['name']=="plantilla_op.xls") && ($tamano_archivo < 1000000000)))
	{
		echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .xls<br><li>se permiten archivos de 1Mb máximo.</td></tr></table>";
	}
	else
	{
		if (move_uploaded_file($HTTP_POST_FILES['path']['tmp_name'], $nombre_archivo)){
		echo "El archivo ha sido cargado correctamente.";
		$ok=1;
		$pagina="plantilla_ops/datos_excel.php";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
		}else{
		echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
		}  
	}
}
else
{   if($action=="Export")
    {
        echo "Exportar archivo";
    }
}

if($ok!=1)
{
?>


<html>
<head>
</head>
<body>

<form id="dataForm" name="dataForm" method="post" enctype="multipart/form-data" action="">

   <input type="file" name="path" id="path" style="width:300px"/>

<input type="submit" value="Import" name="actionButton" id="actionButton" /> <input type="submit" value="Export" name="actionButton" id="actionButton" />

</form>
    <a href="index.html">Inicio</a>
</body>
</html>
<?

}

?>





