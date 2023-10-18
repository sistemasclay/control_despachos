<?php
include("../clases/reportes.php");
include("../clases/fechas.php");
$fechas = new conversiones_fechas();
$repor= new reportes();
$pagina="turno_detalles.php";

if($_POST["seccion"])
{
    $opcion=$_POST["seccion"];
}
else
{
    $opcion=$_GET["seccion"];
}


switch ($opcion)
{
	case "actualiza_turno":
		if($_POST["terminado"]=="on")
		{
			$termino=1;
		}
		else
		{
			$termino=0;
		}
	
	
		$sql="UPDATE turnos SET id_producto='".$_POST["producto"]."', fecha_inicio='".$_POST["fecha_inicio"]."'
				,fecha_fin='".$_POST["fecha_fin"]."', orden_produccion='".$_POST["op"]."', dato_extra='".$_POST["dato_extra"]."'
				, desperdicio_1='".$_POST["d1"]."', desperdicio_2='".$_POST["d2"]."', desperdicio_3='".$_POST["d3"]."'
				,produccion_final='".$_POST["pfinal"]."', terminado='".$termino."',obsevaciones='".$_POST["obs"]."' 
			WHERE id_tabla='".$_POST["tabla_turno"]."'";
	
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$tiempo_turno=$fechas->getDifFechastodo($_POST["fecha_fin"],$_POST["fecha_inicio"]);
		$tiempo_hombre=$tiempo_turno*$_POST["n_empleados"];
		$sql="UPDATE turnos SET tiempo_hombre='".$tiempo_hombre."', tiempo_turno='".$tiempo_turno."'  WHERE id_tabla='".$_POST["tabla_turno"]."'";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		echo "Batch Actualizado";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."?id_proceso=".$_POST["proceso"]."&&turno=".$_POST["turno"]." \">";
	
	break;
          
	case "eliminar_empleado_turno":
		$sql="DELETE FROM turno_asistencia WHERE id_turno_asistencia = '".$_GET["turno_asistencia"]."' ";
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$sql="UPDATE turnos SET tiempo_hombre='".$_GET["tiempo_at"]."' WHERE id_turno='".$_GET["turno"]."' AND id_proceso='".$_GET["proceso"]."'";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		echo "Empleado Eliminado de Batch";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."?id_proceso=".$_GET["proceso"]."&&turno=".$_GET["turno"]." \">";
	break;

	case "agregar_operario":
		//print_r($_POST);
		$sql="insert into turno_asistencia values('".$_POST["turno"]."','".$_POST["proceso"]."','".$_POST["persona"]."','".$_POST["fini"]."'
			,'".$_POST["ffin"]."','0','0')";
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$sql="UPDATE turnos SET tiempo_hombre='".$_POST["tiempo_at"]."' WHERE id_turno='".$_POST["turno"]."' AND id_proceso='".$_POST["proceso"]."'";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}	
		$conexion_pg->Close();
		echo "Empleado Ingresado";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."?id_proceso=".$_POST["proceso"]."&&turno=".$_POST["turno"]." \">";
	break;

	case "modificar_turno_parada":
		$pagina="modificar_paradas.php";	
		$sql="UPDATE turno_parada SET id_parada='".$_POST["n_parada"]."' WHERE id_turno_parada='".$_POST["id_turno_parada"]."'";
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		echo "Parada Modificada";
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."?id_proceso=".$_POST["proceso"]."&&turno=".$_POST["turno"]." \">";
	break;


	case "calcular":
		$sql ="SELECT t.indicador_1,t.indicador_2,t.indicador_3,t.indicador_4,t.indicador_5,t.indicador_6,
			t.indicador_7,t.tiempo_maquina,t.unidades_conteo,t.tiempo_hombre,t.tiempo_turno,t.tiempo_paro_prog,t.tiempo_paro_no_p,
			t.tiempo_paro_g1,t.tiempo_paro_g2,t.tiempo_paro_g3,t.tiempo_total_paro,t.tiempo_std_prog,t.dato_extra,t.desperdicio_1,
			t.desperdicio_2,t.desperdicio_3,t.produccion_final,pp.var1,pp.var2,pp.var3,p.dato_extra1,p.dato_extra2,p.dato_extra3, t.unidades_desperdicio ud
			FROM turnos as t,producto_proceso as pp, productos as p WHERE t.id_tabla='".$_POST["tabla_turno"]."' and pp.id_proceso=t.id_proceso and
			pp.id_producto=t.id_producto and p.id_producto=t.id_producto";

		include("../clases/conexion.php");
		$variables=$conexion_pg->Execute($sql);
		if ($variables === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
			
		echo "<b>Ecuaciones:</b><br/>";
	
		$formulas=$fechas->listar_formulas();
		$i=0;
		while(!$formulas->EOF)
		{
			$formulas_r[$i]=$formulas->fields["formula"];
			echo "Ecuacion ".$i."  ->  ".$formulas->fields["formula"]."<br/>";
			$formulas->MoveNext();
			$i++;
		}	
		echo "<br>";		
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$formulas_r[$i]=str_replace("indicador_1",$variables->fields["indicador_1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_2",$variables->fields["indicador_2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_3",$variables->fields["indicador_3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_4",$variables->fields["indicador_4"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_5",$variables->fields["indicador_5"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_6",$variables->fields["indicador_6"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_7",$variables->fields["indicador_7"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_maquina",$variables->fields["tiempo_maquina"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("datop_extra",$variables->fields["dato_extra"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p1",$variables->fields["dato_extra1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p2",$variables->fields["dato_extra2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p3",$variables->fields["dato_extra3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio1",$variables->fields["desperdicio_1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio2",$variables->fields["desperdicio_2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio3",$variables->fields["desperdicio_3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("produccion_final",$variables->fields["produccion_final"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_averias",$variables->fields["tiempo_paro_g1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_cuadre_ajuste",$variables->fields["tiempo_paro_g2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_pequeñas",$variables->fields["tiempo_paro_g3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_standart_prog",$variables->fields["tiempo_std_prog"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_hombre",$variables->fields["tiempo_hombre"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("total_paro",$variables->fields["tiempo_total_paro"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tot_par_no_p",$variables->fields["tiempo_paro_no_p"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tota_paro_p",$variables->fields["tiempo_paro_prog"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_turno",$variables->fields["tiempo_turno"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("unidades_conteo",$variables->fields["unidades_conteo"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp1",$variables->fields["var1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp2",$variables->fields["var2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp3",$variables->fields["var3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("unidades_desperdicio",$variables->fields["ud"],$formulas_r[$i]);
		}	
		echo "<b>Operaciones ejecutadas:</b><br/>";
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$str = $formulas_r[$i].';';
			eval('$res='.$str);
			echo "Operacion ".$i."  ->  ".$str;
			$indicadores[$i]= Abs($res);
			if(is_float($indicadores[$i]))
			{
				$indicadores[$i]=number_format($indicadores[$i],2,".","");
			}
			echo "  = ".$indicadores[$i]."<br/>";
		}
		
		$sql = "UPDATE turnos SET indicador_1='".$indicadores[0]."',indicador_2='".$indicadores[1]."',indicador_3='".$indicadores[2]."',indicador_4='".$indicadores[3]."',
					indicador_5='".$indicadores[4]."',indicador_6='".$indicadores[5]."',indicador_7='".$indicadores[6]."',tiempo_maquina='".$indicadores[7]."'
				WHERE id_tabla='".$_POST["tabla_turno"]."'";
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		//-------------
		$sql = "SELECT t.indicador_1,t.indicador_2,t.indicador_3,t.indicador_4,t.indicador_5,t.indicador_6,
					t.indicador_7,t.tiempo_maquina,t.unidades_conteo,t.tiempo_hombre,t.tiempo_turno,t.tiempo_paro_prog,t.tiempo_paro_no_p,
					t.tiempo_paro_g1,t.tiempo_paro_g2,t.tiempo_paro_g3,t.tiempo_total_paro,t.tiempo_std_prog,t.dato_extra,t.desperdicio_1,
					t.desperdicio_2,t.desperdicio_3,t.produccion_final,pp.var1,pp.var2,pp.var3,p.dato_extra1,p.dato_extra2,p.dato_extra3, t.unidades_desperdicio ud
				FROM turnos as t,producto_proceso as pp, productos as p WHERE t.id_tabla='".$_POST["tabla_turno"]."' and pp.id_proceso=t.id_proceso and
					pp.id_producto=t.id_producto and p.id_producto=t.id_producto";
	
		include("../clases/conexion.php");
		$variables=$conexion_pg->Execute($sql);
		if ($variables === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
	
		$formulas=$fechas->listar_formulas();
		$i=0;
		while(!$formulas->EOF)
		{
			$formulas_r[$i]=$formulas->fields["formula"];
			$formulas->MoveNext();
			$i++;
		}
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$formulas_r[$i]=str_replace("indicador_1",$variables->fields["indicador_1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_2",$variables->fields["indicador_2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_3",$variables->fields["indicador_3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_4",$variables->fields["indicador_4"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_5",$variables->fields["indicador_5"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_6",$variables->fields["indicador_6"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("indicador_7",$variables->fields["indicador_7"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_maquina",$variables->fields["tiempo_maquina"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("datop_extra",$variables->fields["dato_extra"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p1",$variables->fields["dato_extra1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p2",$variables->fields["dato_extra2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("dato_extra_p3",$variables->fields["dato_extra3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio1",$variables->fields["desperdicio_1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio2",$variables->fields["desperdicio_2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("desperdicio3",$variables->fields["desperdicio_3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("produccion_final",$variables->fields["produccion_final"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_averias",$variables->fields["tiempo_paro_g1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_cuadre_ajuste",$variables->fields["tiempo_paro_g2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("paro_pequeñas",$variables->fields["tiempo_paro_g3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_standart_prog",$variables->fields["tiempo_std_prog"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_hombre",$variables->fields["tiempo_hombre"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("total_paro",$variables->fields["tiempo_total_paro"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tot_par_no_p",$variables->fields["tiempo_paro_no_p"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tota_paro_p",$variables->fields["tiempo_paro_prog"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("tiempo_turno",$variables->fields["tiempo_turno"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("unidades_conteo",$variables->fields["unidades_conteo"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp1",$variables->fields["var1"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp2",$variables->fields["var2"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("Variable_pp3",$variables->fields["var3"],$formulas_r[$i]);
			$formulas_r[$i]=str_replace("unidades_desperdicio",$variables->fields["ud"],$formulas_r[$i]);
			//$formulas_r[$i]=str_replace(",",".",$formulas_r[$i]);
		}
		echo "<br>";
		echo "<b>Operaciones ejecutadas:</b><br/>";
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$str = $formulas_r[$i].';';
			eval('$res='.$str);
			echo "Operacion ".$i."  ->  ".$str;
			$indicadores[$i]= Abs($res);
			if(is_float($indicadores[$i]))
			{
				$indicadores[$i]=number_format($indicadores[$i],2,".","");
			}
			echo "  = ".$indicadores[$i]."<br/>";
		}
	
		$sql = "UPDATE turnos SET indicador_1='".$indicadores[0]."',indicador_2='".$indicadores[1]."',indicador_3='".$indicadores[2]."',indicador_4='".$indicadores[3]."',
					indicador_5='".$indicadores[4]."',indicador_6='".$indicadores[5]."',indicador_7='".$indicadores[6]."',tiempo_maquina='".$indicadores[7]."'
				WHERE id_tabla='".$_POST["tabla_turno"]."'";
		include("../clases/conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		//-----------
		echo "Turno Calculado";
		echo "<br/>";
		echo "<a href='".$pagina."?id_proceso=".$_POST["proceso"]."&&turno=".$_POST["turno"]."'>Volver  </a> ";
	break;

   case "eliminar_turno":

       echo "Eliminando Batch: ".$_POST["turno"]."Del Proceso: ".$_POST["proceso"];
       $sql="DELETE FROM turnos WHERE id_turno=".$_POST["turno"]."and id_proceso=".$_POST["proceso"];
       include("../clases/conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al eliminar Batch: '.$conexion_pg->ErrorMsg().'<BR>';
        }

        $sql="DELETE FROM turno_parada WHERE id_turno=".$_POST["turno"]."and id_proceso=".$_POST["proceso"];
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al eliminar turno_parada: '.$conexion_pg->ErrorMsg().'<BR>';
        }

        $sql="DELETE FROM turno_asistencia WHERE id_turno=".$_POST["turno"]."and id_proceso=".$_POST["proceso"];
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al eliminar turno_asistencia: '.$conexion_pg->ErrorMsg().'<BR>';
        }


        $sql="DELETE FROM turno_log WHERE id_turno=".$_POST["turno"]."and id_proceso=".$_POST["proceso"];
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al eliminar turno_log: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();
        
        $pagina="turnos.php";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina." \">";
}
      
        ?>

