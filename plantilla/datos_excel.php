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
//$objPHPExcel = $objReader->load("Planilla BD Clay VERSION 10.0.xls");
$objPHPExcel = $objReader->load("despachos.xls");

//leer el despacho

$objPHPExcel->setActiveSheetIndex(0);//despacho
$leer_siguiente=1;
$filas_excel=2;
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
   $despacho["id_producto"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $despacho["cantidad_p"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
//se va a agrupar los repetidos en la lista_instituciones
$tamaño_lista = $indice_array;
$iterador_seguimiento = 0;
$iterador_almacenador = 0;
while($iterador_seguimiento < $tamaño_lista){
	
	$producto_actual = $despacho["id_producto"][$iterador_seguimiento];
	$cantidad_actual = $despacho["cantidad_p"][$iterador_seguimiento];
	$segundo_indice = $iterador_seguimiento+1;
	while($segundo_indice < $tamaño_lista){
			if($producto_actual == $despacho["id_producto"][$segundo_indice]){
				$cantidad_actual = $cantidad_actual + $despacho["cantidad_p"][$segundo_indice];
				
				$despacho["id_producto"][$segundo_indice] = null;
				$despacho["cantidad_p"][$segundo_indice] = 0;
			}
		$segundo_indice++;
	}
	if($producto_actual != null){
		$despacho_agrupado["id_producto"][$iterador_almacenador] = $producto_actual;
		$despacho_agrupado["cantidad_p"][$iterador_almacenador] = $cantidad_actual;
		$iterador_almacenador++;
	}
	$iterador_seguimiento++;
}

if($_GET["exportar"]==1){
	include("../clases/reporte_despacho.php");
	$repor= new reportes();
	$repor->pdf_despacho($despacho_agrupado);
}

//print_r($despacho);


?>

<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css"/>
		<link rel="stylesheet" type="text/css" href="../tab/tabcontent.css"  />
		<script type="text/javascript" src="../js/tabcontent.js"></script>
		<script type="text/javascript" src="../js/form-submit.js"></script>
		<script type="text/javascript" src="../js/ajax.js"></script>
		<title>Control de Despachos</title>
	</head>
	<body>
		<table border=0 cellPadding=5 cellSpacing=0 width="100%" >
			<tbody>
				<span>La Hoja De excel Contiene Los Siguentes Datos:</span>
				<tr>
					
					<td valign=top>
						<table border="0" align="left">
							<tr>
								<td valign="top">
									<ul id="countrytabs" class="shadetabs" style="list-style:none">
										<li><a href="#" rel="country1" class="selected">DESPACHO</a></li>
										<br>
										<a href="../index.php">Inicio</a><br>
										<span>Por favor revise que la informacion sea correcta antes de preparar el despacho</span>
										<a href="cargar_datos.php">Cargar a base de datos</a>
										<br>
										<br>
										<a href="datos_excel?exportar=1" target="_blank">PDF</a>
									</ul>
								</td>
								<td valign="top">
									<!--div principal-->
									<div style="border:3px solid gray; width:1000px; height:500px; margin-bottom:auto; padding: 10px">
										<!-- despachos -->
										<div id="country1" class="tabcontent" style="height:500px;">
											<div id="lista_instituciones" style="overflow:scroll; height:500px; overflow-x:hidden;" >
												
												<p align="center" class="white"><b>ITEMS DESPACHO</b></p>
												<table border=1 align=center class="tinfo">
													<tr>
														<th><b>CODIGO<br>PRODUCTO</b></th>
														<th><b>NOMBRE<br>PRODUCTO</b></th>
														<th><b>CANTIDAD SOLICITADA</b></th>
														<th><b>LOTE PRODUCTO</b><th> 

													</tr>
<?
include_once("../clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$registros= count($despacho_agrupado["id_producto"]);

$color=array('impar','par');
$c_estilo=0;
$i=0;
for($i=0;$i<$registros;$i++)
{
	$producto = $datos->detalle_producto_id($despacho_agrupado["id_producto"][$i]);
	
	if($c_estilo%2!=0)
		echo '<tr class="'.$color[0].'">';
	else
		echo '<tr class="'.$color[1].'">';
	
	echo "<td align=\"center\">".$despacho_agrupado["id_producto"][$i]."</td>";
	echo "<td align=\"center\">".$producto->fields['nombre_producto']."</td>";
	echo "<td align=\"center\">".$despacho_agrupado["cantidad_p"][$i]."</td>";
		// echo "<td align=\"center\"> LEo</td>";

    echo "</tr>";
	$c_estilo++;
}
?>
												</table>
											</div>
										</div>
									<!-- fin div principal-->
									</div>
								</td>
							</tr>
						</table>

           	<script type="text/javascript">
           	var countries=new ddtabcontent("countrytabs")
           	countries.setpersist(true)
           	countries.setselectedClassTarget("link") //"link" or "linkparent"
           	countries.init()
			</script>
      </td>
	</tr>
   </tbody>
  </table>
    </body>
</html>
