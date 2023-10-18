<?
/*
include("../clases/fechas.php");
$fechas = new conversiones_fechas();

echo $fechas->getDifFechastodo("2010-07-12 08:30:00","2010-07-08 12:40:00");

$aa = 8;
$bb= 5;*/
$str = "100*(8589/((10111-2224)*60)/3960)";
//echo $str;
 
eval('$res='.$str.';');
echo $res."--";
echo number_format($res,2,".","");
?>
