<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();
$numeroOperarios = $logicaTurno->getNumeroDeOperarios(trim($_REQUEST["proceso"]));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_mic_inicio.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="js/mic_inicio.js"></script>
        <title>Monitoreo y Control</title>
        <script>
<?php echo "var proceso = " . $_REQUEST["proceso"] . ";"; ?>
<?php echo "var numeroOperarios = " . $numeroOperarios . ";"; ?>
        </script>
    </head>
    <body data-estado="inicio" data-loading="off">
        <div class="container selector" ><a href="seleccion_proceso.php"> <div class="img3"></div></a></div>
        <div class="container title" ><div id="title" class="textTitle">header</div></div>
        <div class="container dataIn" ><div id="dataIn" class="textDig">Digite</div></div>
        <div>
        </div>
        <div class="main">	
            <div class="container numberCtn">
                <div class="left">
                    <div class="number" data-val="1" data-down="off"><div class="text">1</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="2" data-down="off"><div class="text">2</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="3" data-down="off"><div class="text">3</div></div>
                </div>    
            </div>
            <div class="container numberCtn">
                <div class="left">
                    <div class="number" data-val="4" data-down="off"><div class="text">4</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="5" data-down="off"><div class="text">5</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="6" data-down="off"><div class="text">6</div></div>
                </div>    
            </div>
            <div class="container numberCtn">
                <div class="left">
                    <div class="number" data-val="7" data-down="off"><div class="text">7</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="8" data-down="off"><div class="text">8</div></div>
                </div>
                <div class="left">
                    <div class="number" data-val="9" data-down="off"><div class="text">9</div></div>
                </div>    
            </div>
            <div class="container numberCtn">
                <div class="left">
                    <div class="number" data-val="cancel" data-press="off"><div class="textCANCEL">CANCEL</div></div>
                </div>
                <div class="left" >
                    <div class="number" data-val="0" data-press="off"><div class="text">0</div></div>
                </div>
                <div class="left" >
                    <div class="number" data-val="ok" data-press="off"><div class="textOK">OK</div></div>
                </div>    
            </div>
        </div>
        <div class="container footer" id="footer">
            <div class="textFotter">PEGASUS PRO <span class="textFotter2"> by </span> <span class="textFotter3"> M&C </span> </div>
        </div>
    </body>
</html>