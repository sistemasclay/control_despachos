<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('memory_limit','512M');
include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_plotline.php');
require_once ('jpgraph/jpgraph_scatter.php');

require('fpdf.php');



class reportes_graficos {

  
/***********
*	Genera la grafica de rangos dado los siguientes datos
*	$parametro: Nombre del parametro al que pertenece la grafica
*	$lie: Representa el Limite Inferior de Especificación //barra ROJA 1
*	$lic: Representa el Limite Inferior de Control //barra NEGRA 1
*	$lsc: Representa el Limite Superior de Control //barra NEGRA 2
*	$lse: Representa el Limite Superior de Especificación //barra ROJA 2
*	$valores: Representa los valores de la linea
*	$turnos: Representa las etiquetas del eje X
***********/

function grafica_rangos($parametro, $lie, $lic, $lsc, $lse, $valores, $turnos)
{
	
$datay1 = $valores;

// Setup the graph
$graph = new Graph(600,750,'auto');

$graph->SetScale("textlin",0,40);
$graph->SetAngle(90);
/*
$theme_class= new UniversalTheme;
$graph->SetTheme($theme_class);
*/
$graph->title->Set("Grafica del Parametro ".$parametro);

$graph->SetBox(false);
$graph->ygrid->SetFill(false);
$graph->yaxis->HideLine(true);
$graph->yaxis->HideTicks(true);
$graph->yaxis->HideZeroLabel();

$graph->xaxis->SetTickLabels($turnos);
// Create the plot
if($lie != 0){
	$l1 = new PlotLine(HORIZONTAL,$lie,"red",2);
	$graph->AddLine($l1);
}

$l2 = new PlotLine(HORIZONTAL,$lic,"black",1);
$graph->AddLine($l2);

$l3 = new PlotLine(HORIZONTAL,$lsc,"black",1);
$graph->AddLine($l3);

if($lse != 0 && $lse > $lsc){
	$l4 = new PlotLine(HORIZONTAL,$lse,"red",2);
	$graph->AddLine($l4);
}

$p1 = new LinePlot($datay1);
$graph->Add($p1);

// Use an image of favourite car as marker
//$p1->mark->SetType(MARK_IMG,'new1.gif',0.8);
$p1->SetColor('#aadddd');
$p1->value->SetFormat('%d');
$p1->value->Show();
$p1->value->SetColor('#55bbdd');

$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$p1->mark->SetColor('#55bbdd');
$p1->mark->SetFillColor('#55bbdd');



$graph->Stroke('grafica x-r.png');
}

function pdf_grafico_rangos($sql_datos)
{
		// echo $sql;
		include("conexion.php");
		$resultDatos=$conexion_pg->Execute($sql_datos);
		if ($resultDatos === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		
		
		$conexion_pg->Close();
		//ob_end_clean();
		$pdf=new FPDF('L','mm','Letter');
		//$pdf->AddPage();
		$pdf->SetFillColor(255, 255, 255);
		$pdf->AddPage();
		$pdf->Image('logo2.jpg',10,8,50);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(80);
		$pdf->Cell(40,8,'Graficos XR',0,0,'C',true);
		//  $pdf->Ln();
		$pdf->Cell(10);
		$pdf->Cell(40,8,$resultProductos->fields['nombre_producto'],0,0,'J',true);		
		
		$datos=array();
		$i=0;
		$j=-1;
		$parametro_actual = "";
		while(!$resultDatos->EOF){
			if($parametro_actual != $resultDatos->fields["id_parametro"]){
				$j++;
				$i=0;
				$parametro_actual = $resultDatos->fields["id_parametro"];
				$datos[$j]["parametro"] = $resultDatos->fields["nombre_parametro"];
				$datos[$j]["lie"] = $resultDatos->fields["limite_inf_espec"];
				$datos[$j]["lic"] = $resultDatos->fields["limite_inf_control"];
				$datos[$j]["lsc"] = $resultDatos->fields["limite_sup_control"];
				$datos[$j]["lse"] = $resultDatos->fields["limite_sup_espec"];
			}
			$datos[$j]["valores"][$i] = $resultDatos->fields["medida"];
			$datos[$j]["turnos"][$i] = $resultDatos->fields["id_registro"];
			
			$resultDatos->MoveNext();
			$i++;
		}
		
		$datos_lenght = count($datos);
		for($j = 0; $j < $datos_lenght; $j++){
			$this->grafica_rangos($datos[$j]["parametro"], $datos[$j]["lie"], $datos[$j]["lic"], $datos[$j]["lsc"], $datos[$j]["lse"], $datos[$j]["valores"], $datos[$j]["turnos"]);
			$pdf->Image('grafica x-r.png',10,30,250,150);
		}
		
		
		$pdf->Output();
}

}
?>
