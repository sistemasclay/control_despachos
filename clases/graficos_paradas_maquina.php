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

 require('fpdf.php');



class reportes_graficos {

 function tiempo_segundos($segundos){
    $minutos=$segundos/60;
    $horas=floor($minutos/60);
    $minutos2=$minutos%60;
    $segundos_2=$segundos%60%60%60;
    if($minutos2<10)$minutos2='0'.$minutos2;
    if($segundos_2<10)$segundos_2='0'.$segundos_2;

    if($segundos<60){ /* segundos */
    $resultado= round($segundos).' Segundos';
    }elseif($segundos>60 && $segundos<3600){/* minutos */
    $resultado= $minutos2.':'.$segundos_2.' Minutos';
    }else{/* horas */
    $resultado= $horas.":".$minutos2.":".$segundos_2;
    }
    return $resultado;
}

function grafica_paradas_maquina($indicadores,$valores)
{
// Some data
$datay=array(1,1,300);

// Create the graph and setup the basic parameters
$graph = new Graph(800,500,'auto');
$graph->img->SetMargin(100,30,30,40);
$graph->SetScale("textint");
$graph->SetShadow();
$graph->SetFrame(false); // No border around the graph
// Add some grace to the top so that the scale doesn't
// end exactly at the max value.

$graph->yaxis->scale->SetGrace(20);
$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD,10);
// Setup X-axis labels
//$a = array(250,251,256);//$gDateLocale->GetShortMonth();
//$graph->xaxis->SetTickLabels($a);
$graph->xaxis->SetTickLabels($indicadores);
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD,12);
//$graph->yaxis->title->Set("Unidades Conteo");
//$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);

// Setup graph title ands fonts
$graph->title->Set("GRAFICA PARADAS");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,24);
$graph->xaxis->title->Set("Tipo Parada");
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,16);

// Create a bar pot
//$bplot = new BarPlot($datay);
$bplot = new BarPlot($valores);
//$bplot->SetFillColor(array('royalblue2','seagreen4','yellow2'));
$bplot->SetFillColor('#FF0000');
$bplot->SetWidth(0.5);
//$bplot->SetShadow();

// Setup the values that are displayed on top of each bar
$bplot->value->Show();

// Must use TTF fonts if we want text at an arbitrary angle
//$bplot->value->SetFont(FF_ARIAL,FS_BOLD);
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,10);
$bplot->value->SetAngle(45);

// Black color for positive values and darkred for negative values
$bplot->value->SetColor("black","darkred");
$graph->Add($bplot);

if (file_exists('paro_maquina.png'))
{
   unlink('paro_maquina.png');
}
// Finally stroke the graph
$graph->Stroke('paro_maquina.png');

}

  function pdf_paradas_maquina($sql)
    {
    //  echo $sql."<br>";
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        // print_r($result);
        //ob_end_clean();
         
    $pdf=new FPDF('L','mm','Letter');
        //$pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->AddPage();
    $pdf->Image('logo.jpg',10,8,33);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(80);
    $pdf->Cell(35,8,'Grafico Paradas',0,0,'L',true);
  //  $pdf->Ln();
    $pdf->Cell(10);
    $pdf->Cell(35,8,$result->fields['nombre'],0,0,'L',true);
   $pdf->Cell(10);
   $pdf->Cell(30,8,'Tiempo Total :',0,0,'L',true);
    $pdf->Cell(10);

$registros==0;
$g1=0;
$g2=0;
$g3=0;
$ttotal=0;
    while (!$result->EOF) {
        
    $g1=$g1+$result->fields["tiempo_paro_g1"];
    $g2=$g2+$result->fields["tiempo_paro_g2"];
    $g3=$g3+$result->fields["tiempo_paro_g3"];
    $ttotal=$ttotal+$result->fields["tiempo_total_paro"];
        $registros++;

        $result->MoveNext();
    }
    $pdf->Cell(40,8,$this->tiempo_segundos($ttotal),0,0,'L',true);
                 if($registros==0)
         {
             echo "no existen Batchs para esta maquina";
             exit;
         }
    $i=0;
    $tdiponibilidad=0;
    $tvelocidad=0;
    $tcalidad=0;
   
$indicadores=array();
$indicadores[0]="Averias";
$indicadores[1]="Cuadre y Ajuste";
$indicadores[2]="Pequenas Paradas";

$valores=array();
$valores[0]=floor($g1/60);
$valores[1]=floor($g2/60);
$valores[2]=floor($g3/60);

    $this->grafica_paradas_maquina($indicadores,$valores);
    $pdf->Image('paro_maquina.png',10,30,250,150);
    $pdf->Output();
    }

     

}
?>
