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

   function detalle_proceso($codigo)
    {
        include("conexion.php");
        $sql="SELECT * FROM procesos WHERE id_proceso = '$codigo'";
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
            {
            echo 'error al Buscar: '.$conn->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }


        function listar_etiquetas()
    {
        include("conexion.php");
       // $sql =	"SELECT * FROM ordenes_produccion";
       $sql = "SELECT * FROM variables order by id_variable";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
            $conexion_pg->Close();
            $i=0;
        while (!$result->EOF)
	{
			$ar[$i]["etiqueta"]=$result->fields["etiqueta"];
			$result->MoveNext();
			$i++;
	}
         return $ar;
    }


    function listar_paradas()
    {
        include("conexion.php");
       // $sql =	"SELECT * FROM ordenes_produccion";
       $sql = "SELECT * FROM paradas order by id_parada";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
            $conexion_pg->Close();
        $i=0;
        while (!$result->EOF)
	{
			$ar[$i]["id_parada"]=$result->fields["id_parada"];
                        $ar[$i]["nombre_parada"]=$result->fields["nombre_parada"];
			$result->MoveNext();
			$i++;
	}
         return $ar;
    }


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

function grafica_oee_empleado($indicadores,$valores)
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
$graph->yaxis->scale->SetGrace(10);
$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD,10);
// Setup X-axis labels
//$a = array(250,251,256);//$gDateLocale->GetShortMonth();
//$graph->xaxis->SetTickLabels($a);
$graph->xaxis->SetTickLabels($indicadores);
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD,12);
//$graph->xaxis->SetLabelAngle(45);

//$graph->yaxis->title->Set("Unidades Conteo");
//$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
// Setup graph title ands fonts
$graph->title->Set("GRAFICA OEE");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,24);
$graph->xaxis->title->Set("Indicadores");
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,16);
// Create a bar pot
//$bplot = new BarPlot($datay);
$bplot = new BarPlot($valores);
$bplot->SetFillColor(array('#002060','#002060','#002060','#FF0000'));
//$bplot->SetFillColor('#FF0000');
$bplot->SetWidth(0.5);
//$bplot->SetShadow();
// Setup the values that are displayed on top of each bar
$bplot->value->Show();
// Must use TTF fonts if we want text at an arbitrary angle
//$bplot->value->SetFont(FF_ARIAL,FS_BOLD);
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,14);
$bplot->value->SetAngle(45);
// Black color for positive values and darkred for negative values
$bplot->value->SetColor("black","darkred");
$graph->Add($bplot);

if (file_exists('oee_maquina.png'))
{
   unlink('oee_maquina.png');
}
// Finally stroke the graph
$graph->Stroke('oee_maquina.png');

}

  function pdf_grafico_oee_empleado($sql,$inf)
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
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Grafico OEE para',0,0,'C',true);
  //  $pdf->Ln();
    $pdf->Cell(5);
    $pdf->Cell(40,8,$result->fields['nombre_persona'].", ".$inf,0,0,'L',true);
    
    $velocidad=array();
    $disponibilidad=array();
    $calidad=array();
    $tiempo_total=0;
     $unidades_total=0;
    $registros=0;
    while (!$result->EOF) {
        $disponibilidad[]=($result->fields["indicador_1"]/100)*($result->fields["tiempo_turno"]/60);
        $velocidad[]=(($result->fields["indicador_2"])/100)*($result->fields["tiempo_turno"]/60);
        $calidad[]=(($result->fields["indicador_3"])/100)*$result->fields["unidades_conteo"];
        $tiempo_total=$tiempo_total+($result->fields["tiempo_turno"]/60);
        $unidades_total=$unidades_total+$result->fields["unidades_conteo"];
        $registros++;
        $result->MoveNext();
    }
             if($registros==0)
         {
             echo "no existen Batchs para este empleado";
             exit;
         }
    $i=0;
    $tdiponibilidad=0;
    $tvelocidad=0;
    $tcalidad=0;
    for($i=0;$i<$registros;$i++)
    {
        $tdiponibilidad=$tdiponibilidad+$disponibilidad[$i];
        $tvelocidad=$tvelocidad+$velocidad[$i];
        $tcalidad=$tcalidad+$calidad[$i];
    }
    
$tdiponibilidad=($tdiponibilidad/$tiempo_total)*100;
$tvelocidad=($tvelocidad/$tiempo_total)*100;
$tcalidad=($tcalidad/$unidades_total)*100;
$oee=($tdiponibilidad*$tvelocidad*$tcalidad)/10000;

/*echo "Disponibilidad : ".$tdiponibilidad;

    echo "<br>";
    echo "Velocidad : ".$tvelocidad;
    echo "<br>";
    echo "Calidad : ".$tcalidad;
    echo "<br>";
    echo "OEE : ".$oee;
*/
$indicadores=array();
$indicadores[0]="Disponibilidad";
$indicadores[1]="Velocidad";
$indicadores[2]="Calidad";
$indicadores[3]="OEE";
$valores=array();
$valores[0]=floor($tdiponibilidad);
$valores[1]=floor($tvelocidad);
$valores[2]=floor($tcalidad);
$valores[3]=floor($oee);
    $this->grafica_oee_empleado($indicadores,$valores);
    $pdf->Image('oee_maquina.png',10,30,250,150);
    $pdf->Output();
    }

     

}
?>
