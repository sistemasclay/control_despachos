<?php
include("../../clases/reportes_graficos.php");
$repor= new reportes_graficos();
$pagina="graficos.php";

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

    }

if($_POST["opcion"]=="turno")
    {
        if($_POST["tini"] > $_POST["tfin"])
        {
           echo "El Batch de inicio debe ser menor al BAtch final";
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
    }

$sql="";
        
switch ($_POST["tipo"])
{
	//GRAFICA DE PRODUCCION
	  case "8":
				if($_POST["opcion"]=="turno")
				{
					$sql = "SELECT b.id_turno id_turno, b.produccion_final produccion_final, a.nombre, p.nombre_persona persona
							FROM turnos as b 
								INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
								INNER JOIN (SELECT id_turno turno,
													id_proceso proceso,
													id_empleado oper
											FROM turno_asistencia
												INNER JOIN (SELECT min(id_turno) turno,
																min(id_proceso) proceso,
																min(id_turno_asistencia)ta
														FROM turno_asistencia
														GROUP BY id_turno, id_proceso) tp on tp.ta = id_turno_asistencia
									) tt ON tt.turno = b.id_turno AND tt.proceso = b.id_proceso
								INNER JOIN personal p ON tt.oper = p.id_persona
							WHERE b.id_proceso='".$_POST["id_proceso"]."' AND id_turno<='".$_POST["tfin"]."' AND id_turno>='".$_POST["tini"]."' order by b.id_turno  ASC"; //order by cast(unidades_conteo as numeric)
				}
				else
				{
                  
					if($_POST["opcion"]=="fecha")
					{
						$sql = "SELECT b.id_turno id_turno, b.produccion_final produccion_final, a.nombre, p.nombre_persona persona
								FROM turnos as b 
									INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
									INNER JOIN (SELECT id_turno turno,
														id_proceso proceso,
														id_empleado oper
												FROM turno_asistencia
													INNER JOIN (SELECT min(id_turno) turno,
																	min(id_proceso) proceso,
																	min(id_turno_asistencia)ta
															FROM turno_asistencia
															GROUP BY id_turno, id_proceso) tp on tp.ta = id_turno_asistencia
										) tt ON tt.turno = b.id_turno AND tt.proceso = b.id_proceso
									INNER JOIN personal p ON tt.oper = p.id_persona
								WHERE b.id_proceso='".$_POST["id_proceso"]."' AND fecha_inicio<='".$_POST["fechaf"]."' AND fecha_inicio>='".$_POST["fechai"]."' order by b.id_turno  ASC"; //order by cast(unidades_conteo as numeric)
					}
				}
             //     echo $sql;
             $repor->pdf_grafico_produccion($sql);
          break;
	//GRAFICA DE OCURRENCIA DE PARADAS
          case "9":
              if($_POST["opcion"]=="turno")
              {
               $sql = "	SELECT id_parada 
						FROM turno_parada  
						WHERE id_proceso='".$_POST["id_proceso"]."' 
							AND id_turno<='".$_POST["tfin"]."' 
							AND id_turno>='".$_POST["tini"]."'";
              }
              else
                  {
                      if($_POST["opcion"]=="fecha")
                      {
                       $sql = "	SELECT 	id_parada 
								FROM 	turno_parada  
								WHERE 	id_proceso='".$_POST["id_proceso"]."' 
									AND fecha_inicio<='".$_POST["fechaf"]."' 
									AND fecha_inicio>='".$_POST["fechai"]."'";
                      }
                  }
                    $repor->pdf_grafico_ocurrencias($sql,$_POST["id_proceso"]);
          break;
	//GRAFICA DE TIEMPO EN PARADAS
          case "10":
              if($_POST["opcion"]=="turno")
              {
               $sql = "SELECT id_parada,horas FROM turno_parada  WHERE id_proceso='".$_POST["id_proceso"]."' AND id_turno<='".$_POST["tfin"]."' AND id_turno>='".$_POST["tini"]."' ";
              }
              else
                  {
                      if($_POST["opcion"]=="fecha")
                      {
                        $sql = "SELECT id_parada,horas FROM turno_parada  WHERE id_proceso='".$_POST["id_proceso"]."' AND fecha_inicio<='".$_POST["fechaf"]."' AND fecha_inicio>='".$_POST["fechai"]."'";
                      }
                  }
                    $repor->pdf_grafico_tiempo_paro($sql,$_POST["id_proceso"]);
          break;

           default:
              // echo "4565..";
             if($_POST["opcion"]=="turno")
              {
               $sql = "SELECT id_turno,nombre,indicador_1,indicador_2,indicador_3,indicador_4,indicador_5,indicador_6,indicador_7
                FROM turnos as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
                WHERE b.id_proceso='".$_POST["id_proceso"]."' AND id_turno<='".$_POST["tfin"]."' AND id_turno>='".$_POST["tini"]."' order by id_turno";
              }
              else
                  {
                      if($_POST["opcion"]=="fecha")
                      {
                       $sql = "SELECT id_turno,nombre,indicador_1,indicador_2,indicador_3,indicador_4,indicador_5,indicador_6,indicador_7
                        FROM turnos as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso)
                        WHERE b.id_proceso='".$_POST["id_proceso"]."' AND fecha_inicio<='".$_POST["fechaf"]."' AND fecha_inicio>='".$_POST["fechai"]."' order by id_turno";
                      }
                  }
             $repor->pdf_grafico_indicadores($sql,$_POST["tipo"]);
          break;
          
}
      
        ?>

