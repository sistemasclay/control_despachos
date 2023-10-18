<?
require 'modelo/LogicaTurno.php';
  $logicaTurno = new LogicaTurno();
  $proceso = $_REQUEST["proceso"];
  $numeroOperarios = $logicaTurno->validarSalida(trim($proceso));
	if($_REQUEST["call"]==1 || $_REQUEST["call"]==2)
	{
		$logicaTurno->llamado($proceso, $_REQUEST["call"]-1);
		//echo $datos_planta->fields["nombre"]."-".$datos_planta->fields["id_planta"];
	}
	$llamado = $logicaTurno->esta_llamando($proceso);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_mic_parada_regis.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="js/mic_parada_regis.js"></script>
        <title>Monitoreo y Control</title>
        <script>
<?php  echo "var proceso = ".$proceso.";";  ?>
<?php // echo "var numeroOperarios = ".$numeroOperarios.";";  ?>
        </script>
    </head>
    <body data-estado="inicio" data-loading="on">
        <div class="container title" >
            <div id="maquina" class="textTitle maquina">Maquina</div>
            <div id="turno" class="textTitle turno">Turno</div>                
        </div>
        <div class="main">	
            <div class="container Ctn1">
                <a href="mic_parada_regis.php?proceso=<?php echo $proceso;?>&&call=<?echo $llamado+1;?>"><div class="<?echo ($llamado+1 == 2 ? 'playizqoff' : 'playizqon');?>"></div></a>
                <div class="play"></div>            
                <div class="playder"></div>            
                <div class="ctnImg">
                    <a href="seleccion_proceso.php"> <div class="img1"></div></a>
					<a href="mic_cerrar_turno.php?proceso=<?php echo $_REQUEST["proceso"]?>"> <div class="img2"></div> </a>  
                </div>
            </div>
            <div class="container Ctn2">
				<div id="time" class="time"></div>
                <a href="mic_regis_paro.php?proceso=<?php echo trim($_REQUEST["proceso"]); ?>" class="link"><div class="inBlank"><span>INGRESE CAUSAL</span></div></a>
            </div>
        </div>
        <div class="container footer" id="footer">
            <div class="textFotter">PEGASUS PRO <span class="textFotter2"> by </span> <span class="textFotter3"> M&C </span> </div>
        </div>
    </body>
</html>