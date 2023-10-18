<?php
include("../../clases/graficos_oee_maquina.php");
$repor= new reportes_graficos();
$pagina="graficos_oee_maquina.php";

//echo $_POST["id_proceso"];

if($_POST["opcion"]=="fecha")
    {
            if($_POST["fechai"] > $_POST["fechaf"])
        {
           echo "La fecha de inicio debe ser menor al fecha final";
           $_POST["tipo"]=100;
           echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
        }
				$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
		$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";

        $inf= "De ".$_POST["fechai"]." a ".$_POST["fechaf"];
		
    }

if($_POST["opcion"]=="turno")
    {
        if($_POST["tini"] > $_POST["tfin"])
        {
           echo "El BAtch de inicio debe ser menor al Batch final";
           $_POST["tipo"]=100;
           echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";                    
        }
            if($_POST["tini"]=="")
        {
          echo "Debe seleccionar interbalo de Batchs";
           $_POST["tipo"]=100;
           echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
        }
       if($_POST["tfin"]=="")
        {
          echo "Debe seleccionar interbalo de Batchs";
           $_POST["tipo"]=100;
           echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
        }
         $inf= "De ".$_POST["tini"]." a ".$_POST["tfin"];
    }

$sql="";
        
              if($_POST["opcion"]=="turno")
              {
               $sql = "SELECT nombre,indicador_1,indicador_2,indicador_3,tiempo_turno,unidades_conteo
                FROM turnos as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
                WHERE b.id_proceso='".$_POST["id_proceso"]."' AND id_turno<='".$_POST["tfin"]."' AND id_turno>='".$_POST["tini"]."'"; // order by id_turno
              }
              else
                  {                  
                      if($_POST["opcion"]=="fecha")
                      {
                       $sql = "SELECT nombre,indicador_1,indicador_2,indicador_3,tiempo_turno,unidades_conteo
                        FROM turnos as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
                        WHERE b.id_proceso='".$_POST["id_proceso"]."' AND fecha_inicio<='".$_POST["fechaf"]."' AND fecha_inicio>='".$_POST["fechai"]."'";
                      }
                  }                  
             $repor->pdf_grafico_oee_maquina($sql,$inf);

    

      
        ?>

