<?php
ini_set('memory_limit','1024M');
/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once '../clases/PHPExcel.php';

/** PHPExcel_IOFactory */
require_once '../clases/PHPExcel/IOFactory.php';
require_once '../clases/PHPExcel/Reader/Excel5.php';

$objReader = new PHPExcel_Reader_Excel5();
$objPHPExcel = $objReader->load("plantilla_op.xls");


//leer las plantas

$objPHPExcel->setActiveSheetIndex(1);//plantas
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
	$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
	if($valor_celda=="")
	{
		$leer_siguiente=0;
	}
	else
	{
		$ops["id_op"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
		$ops["id_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
		$ops["id_proceso"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
		$ops["fecha_ini"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
		$ops["fecha_fin"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
		$ops["cantidad"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5,$filas_excel)->getValue();
		$ops["max_dias"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6,$filas_excel)->getValue();
		$ops["porc_ref"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7,$filas_excel)->getValue();
		$filas_excel++;
		$indice_array++;
	}
}
//print_r($plantas);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../tab/tabcontent.css"  />
<script type="text/javascript" src="../tab/tabcontent.js"></script>
<script type="text/javascript" src="../js/form-submit.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
    </head>
    <body>

		 <a href="../index.html">Inicio</a><br>
                 Por favor revise que la informacion sea correcta
                  <a href="cargar_datos.php">Cargar a base de datos</a>

 <div id="lista_instituciones" style="overflow:scroll; height:500px; overflow-x:hidden;" >

<p align="center" class="style1"><b>Ordenes de Produccion</b></p>

<table border=1 align=center>
<tr>
  <td ><b>Codigo</b></td>
  <td > <b> Proceso </b></td>
  <td > <b> Producto </b></td>
  <td > <b> Cantidad </b></td>
  <td > <b> Fecha Inicio </b></td>
  <td > <b> Fecha Fin </b></td>
</tr>
<?
$registros= count($ops["id_op"]);

$i=0;

for($i=0;$i<$registros;$i++)
{
    echo "<tr>";
echo "<td>".$ops["id_op"][$i]."</td>";
echo "<td>".$ops["id_proceso"][$i]."</td>";
echo "<td>".$ops["id_producto"][$i]."</td>";
echo "<td>".$ops["cantidad"][$i]."</td>";
echo "<td>".$ops["fecha_ini"][$i]."</td>";
echo "<td>".$ops["fecha_fin"][$i]."</td>";
echo "<td>".$ops["max_dias"][$i]."</td>";
echo "<td>".$ops["porc_ref"][$i]."</td>";
    echo "</tr>";
}
?>
</table>

</div>
 
    </body>
</html>
