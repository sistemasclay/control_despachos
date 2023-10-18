<?php

ini_set('memory_limit', '2048M');
set_time_limit (0);

include("../clases/adodb5/adodb-exceptions.inc.php");
include("../clases/adodb5/adodb.inc.php");
date_default_timezone_set('America/Lima');

include("../clases/fechas.php");
		
	
	function traerMaquinas(){
		$sql = "SELECT * FROM procesos ";
		include("../clases/conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$i=0;
		while(!$result->EOF)
		{
			$maquinas[$i]=$result->fields["id_proceso"];
			$result->MoveNext();
			$i++;
		}
		$conexion_pg->Close();
		return $maquinas;
	}
	
	function traerTurnosMaquina($maquina){
		$sql = "SELECT * FROM turnos WHERE id_proceso = $maquina ";
		include("../clases/conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$i=0;
		while(!$result->EOF)
		{
			$turnos[$i]=$result->fields["id_turno"];
			$result->MoveNext();
			$i++;
		}
		$conexion_pg->Close();
		return $turnos;
	}
	
	function calcular_indicadores($maquina, $turno)
	{
		$fechas = new conversiones_fechas();
		$sql ="SELECT 	CASE WHEN coalesce(t.indicador_1, '1') ='0' THEN '1' ELSE coalesce(t.indicador_1, '1') END indicador_1,
						CASE WHEN coalesce(t.indicador_2, '1') ='0' THEN '1' ELSE coalesce(t.indicador_2, '1') END indicador_2,
						CASE WHEN coalesce(t.indicador_3, '1') ='0' THEN '1' ELSE coalesce(t.indicador_3, '1') END indicador_3,
						CASE WHEN coalesce(t.indicador_4, '1') ='0' THEN '1' ELSE coalesce(t.indicador_4, '1') END indicador_4,
						CASE WHEN coalesce(t.indicador_5, '1') ='0' THEN '1' ELSE coalesce(t.indicador_5, '1') END indicador_5,
						CASE WHEN coalesce(t.indicador_6, '1') ='0' THEN '1' ELSE coalesce(t.indicador_6, '1') END indicador_6,
						CASE WHEN coalesce(t.indicador_7, '1') ='0' THEN '1' ELSE coalesce(t.indicador_7, '1') END indicador_7,
						CASE WHEN coalesce(t.tiempo_maquina, 1) =0 THEN 1 ELSE coalesce(t.tiempo_maquina, 1) END tiempo_maquina,
						CASE WHEN coalesce(t.unidades_conteo, '1') ='0' THEN '1' ELSE coalesce(t.unidades_conteo, '1') END unidades_conteo,
						CASE WHEN coalesce(t.tiempo_hombre, 1) =0 THEN 1 ELSE coalesce(t.tiempo_hombre, 1) END tiempo_hombre,
						CASE WHEN coalesce(t.tiempo_turno, 1) =0 THEN 1 ELSE coalesce(t.tiempo_turno, 1) END tiempo_turno,
						CASE WHEN coalesce(t.tiempo_paro_prog, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_prog, 1) END tiempo_paro_prog,
						CASE WHEN coalesce(t.tiempo_paro_no_p, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_no_p, 1) END tiempo_paro_no_p,
						CASE WHEN coalesce(t.tiempo_paro_g1, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g1, 1) END tiempo_paro_g1,
						CASE WHEN coalesce(t.tiempo_paro_g2, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g2, 1) END tiempo_paro_g2,
						CASE WHEN coalesce(t.tiempo_paro_g3, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g3, 1) END tiempo_paro_g3,
						CASE WHEN coalesce(t.tiempo_total_paro, 1) =0 THEN 1 ELSE coalesce(t.tiempo_total_paro, 1) END tiempo_total_paro,
						CASE WHEN coalesce(t.tiempo_std_prog, 1) =0 THEN 1 ELSE coalesce(t.tiempo_std_prog, 1) END tiempo_std_prog,
						CASE WHEN coalesce(t.dato_extra, 1) =0 THEN 1 ELSE coalesce(t.dato_extra, 1) END dato_extra,
						CASE WHEN coalesce(t.desperdicio_1, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_1, 1) END desperdicio_1,
						CASE WHEN coalesce(t.desperdicio_2, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_2, 1) END desperdicio_2,
						CASE WHEN coalesce(t.desperdicio_3, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_3, 1) END desperdicio_3,
						CASE WHEN coalesce(t.produccion_final, 1) =0 THEN 1 ELSE coalesce(t.produccion_final, 1) END produccion_final,
						CASE WHEN coalesce(pp.var1, '1') ='0' THEN '1' ELSE coalesce(pp.var1, '1') END var1,
						CASE WHEN coalesce(pp.var2, '1') ='0' THEN '1' ELSE coalesce(pp.var2, '1') END var2,
						CASE WHEN coalesce(pp.var3, '1') ='0' THEN '1' ELSE coalesce(pp.var3, '1') END var3,
						CASE WHEN coalesce(p.dato_extra1, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra1, '1') END dato_extra1,
						CASE WHEN coalesce(p.dato_extra2, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra2, '1') END dato_extra2,
						CASE WHEN coalesce(p.dato_extra3, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra3, '1') END dato_extra3
				FROM turnos AS t
					LEFT JOIN producto_proceso pp ON pp.id_proceso = t.id_proceso AND pp.id_producto = t.id_producto 
					LEFT JOIN productos p ON p.id_producto=t.id_producto
				WHERE t.id_proceso=$maquina AND t.id_turno = $turno";

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
			$formulas_r[$i]=str_replace(",",".",$formulas_r[$i]);
		}
	
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$str = $formulas_r[$i].';';
			eval('$res='.$str);
			$indicadores[$i]= Abs($res);
			if(is_float($indicadores[$i]))
			{
				$indicadores[$i]=number_format($indicadores[$i],2,".","");
			}
		}
		
		$sql = "UPDATE turnos
				SET indicador_1='".$indicadores[0]."',
					indicador_2='".$indicadores[1]."',
					indicador_3='".$indicadores[2]."',
					indicador_4='".$indicadores[3]."',
					indicador_5='".$indicadores[4]."',
					indicador_6='".$indicadores[5]."',
					indicador_7='".$indicadores[6]."',
					tiempo_maquina='".$indicadores[7]."'
				WHERE id_proceso=$maquina AND id_turno = $turno";
		
		include("../clases/conexion.php");
        if ($conexion_pg->Execute($sql) === false)
            die("fallo consulta");		
		$conexion_pg->Close();
		//-----------------------------------------
		//SE DEBE REPETIR LA ACCION PARA PODER ACTUALIZAR DATOS QUE DEPENDEN DE OTROS
		//-----------------------------------------
		//include("../clases/fechas.php");
		//$fechas = new conversiones_fechas();
		
		$sql ="SELECT 	CASE WHEN coalesce(t.indicador_1, '1') ='0' THEN '1' ELSE coalesce(t.indicador_1, '1') END indicador_1,
						CASE WHEN coalesce(t.indicador_2, '1') ='0' THEN '1' ELSE coalesce(t.indicador_2, '1') END indicador_2,
						CASE WHEN coalesce(t.indicador_3, '1') ='0' THEN '1' ELSE coalesce(t.indicador_3, '1') END indicador_3,
						CASE WHEN coalesce(t.indicador_4, '1') ='0' THEN '1' ELSE coalesce(t.indicador_4, '1') END indicador_4,
						CASE WHEN coalesce(t.indicador_5, '1') ='0' THEN '1' ELSE coalesce(t.indicador_5, '1') END indicador_5,
						CASE WHEN coalesce(t.indicador_6, '1') ='0' THEN '1' ELSE coalesce(t.indicador_6, '1') END indicador_6,
						CASE WHEN coalesce(t.indicador_7, '1') ='0' THEN '1' ELSE coalesce(t.indicador_7, '1') END indicador_7,
						CASE WHEN coalesce(t.tiempo_maquina, 1) =0 THEN 1 ELSE coalesce(t.tiempo_maquina, 1) END tiempo_maquina,
						CASE WHEN coalesce(t.unidades_conteo, '1') ='0' THEN '1' ELSE coalesce(t.unidades_conteo, '1') END unidades_conteo,
						CASE WHEN coalesce(t.tiempo_hombre, 1) =0 THEN 1 ELSE coalesce(t.tiempo_hombre, 1) END tiempo_hombre,
						CASE WHEN coalesce(t.tiempo_turno, 1) =0 THEN 1 ELSE coalesce(t.tiempo_turno, 1) END tiempo_turno,
						CASE WHEN coalesce(t.tiempo_paro_prog, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_prog, 1) END tiempo_paro_prog,
						CASE WHEN coalesce(t.tiempo_paro_no_p, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_no_p, 1) END tiempo_paro_no_p,
						CASE WHEN coalesce(t.tiempo_paro_g1, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g1, 1) END tiempo_paro_g1,
						CASE WHEN coalesce(t.tiempo_paro_g2, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g2, 1) END tiempo_paro_g2,
						CASE WHEN coalesce(t.tiempo_paro_g3, 1) =0 THEN 1 ELSE coalesce(t.tiempo_paro_g3, 1) END tiempo_paro_g3,
						CASE WHEN coalesce(t.tiempo_total_paro, 1) =0 THEN 1 ELSE coalesce(t.tiempo_total_paro, 1) END tiempo_total_paro,
						CASE WHEN coalesce(t.tiempo_std_prog, 1) =0 THEN 1 ELSE coalesce(t.tiempo_std_prog, 1) END tiempo_std_prog,
						CASE WHEN coalesce(t.dato_extra, 1) =0 THEN 1 ELSE coalesce(t.dato_extra, 1) END dato_extra,
						CASE WHEN coalesce(t.desperdicio_1, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_1, 1) END desperdicio_1,
						CASE WHEN coalesce(t.desperdicio_2, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_2, 1) END desperdicio_2,
						CASE WHEN coalesce(t.desperdicio_3, 1) =0 THEN 1 ELSE coalesce(t.desperdicio_3, 1) END desperdicio_3,
						CASE WHEN coalesce(t.produccion_final, 1) =0 THEN 1 ELSE coalesce(t.produccion_final, 1) END produccion_final,
						CASE WHEN coalesce(pp.var1, '1') ='0' THEN '1' ELSE coalesce(pp.var1, '1') END var1,
						CASE WHEN coalesce(pp.var2, '1') ='0' THEN '1' ELSE coalesce(pp.var2, '1') END var2,
						CASE WHEN coalesce(pp.var3, '1') ='0' THEN '1' ELSE coalesce(pp.var3, '1') END var3,
						CASE WHEN coalesce(p.dato_extra1, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra1, '1') END dato_extra1,
						CASE WHEN coalesce(p.dato_extra2, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra2, '1') END dato_extra2,
						CASE WHEN coalesce(p.dato_extra3, '1') ='0' THEN '1' ELSE coalesce(p.dato_extra3, '1') END dato_extra3
				FROM turnos AS t
					LEFT JOIN producto_proceso pp ON pp.id_proceso = t.id_proceso AND pp.id_producto = t.id_producto 
					LEFT JOIN productos p ON p.id_producto=t.id_producto
				WHERE t.id_proceso=$maquina AND t.id_turno = $turno";

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
			$formulas_r[$i]=str_replace(",",".",$formulas_r[$i]);
		}
	
		for( $i = 0; $i < count($formulas_r); $i ++)
		{
			$str = $formulas_r[$i].';';
			eval('$res='.$str);
			$indicadores[$i]= Abs($res);
			if(is_float($indicadores[$i]))
			{
				$indicadores[$i]=number_format($indicadores[$i],2,".","");
			}
		}
		
		$sql = "UPDATE turnos
				SET indicador_1='".$indicadores[0]."',
					indicador_2='".$indicadores[1]."',
					indicador_3='".$indicadores[2]."',
					indicador_4='".$indicadores[3]."',
					indicador_5='".$indicadores[4]."',
					indicador_6='".$indicadores[5]."',
					indicador_7='".$indicadores[6]."',
					tiempo_maquina='".$indicadores[7]."'
				WHERE id_proceso=$maquina AND id_turno = $turno";
		
		include("../clases/conexion.php");
        if ($conexion_pg->Execute($sql) === false)
            die("fallo consulta");		
		$conexion_pg->Close();
	}
	
	$maquinas = traerMaquinas();
	foreach($maquinas as $maquina){
		$turnos = traerTurnosMaquina($maquina);
		echo $maquina."<br>";
		foreach($turnos as $turno){
			echo $turno.",";
			calcular_indicadores($maquina,$turno);
		}
		echo"<br>";
	}
	$pagina="../index.php";
	echo "<meta http-equiv=\"refresh\" content=\"10;URL=".$pagina."\">";

?>
