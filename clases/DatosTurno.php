<?php

include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");
date_default_timezone_set('America/Lima');

class DatosTurno {

    public function DatosTurno() {
        // Tratado como constructor en PHP 5.3.0 - 5.3.2
        // Tratado como método regular a partir de PHP 5.3.3
    }

    public function getNumeroOperarios($numeroMaquina) {
        $sql = "SELECT cant_operarios FROM procesos WHERE  id_proceso='$numeroMaquina' ";
          include("conexion.php");
          $result = $conexion_pg->Execute($sql);
          if ($result === false) die("fallo consulta");
          $conexion_pg->Close();
          $result->MoveFirst();
          return $result->fields["cant_operarios"];
//return 2;
    }

    public function validarOperario($codigo) {
		$sql = "SELECT count(*) cnt FROM personal WHERE id_persona ='$codigo' ";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		$result->MoveFirst();
		return (int) $result->fields["cnt"] > 0 ? true : false;
//return true;
    }

    public function validarOP($codigo) {
		$sql = "SELECT count(*) cnt FROM ordenes_produccion WHERE id_orden_produccion ='$codigo' ";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		$result->MoveFirst();
		return (int) $result->fields["cnt"] > 0 ? true : false;
//return true;
    }

    public function validarProducto($codigo) {
		$sql = "SELECT count(*) cnt FROM productos WHERE id_producto ='$codigo' ";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		$result->MoveFirst();
		return (int) $result->fields["cnt"] > 0 ? true : false;
    }
	
	public function validarParada($codigo) {
		$sql = "SELECT count(*) cnt FROM paradas WHERE id_parada ='$codigo' ";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		$result->MoveFirst();
		return (int) $result->fields["cnt"] > 0 ? true : false;
    }
	
	public function validarTurnoCerrado($maquina, $turno) {
		$sql = "SELECT count(*) cnt FROM turnos WHERE id_proceso ='$maquina' AND id_turno = '$turno' AND terminado = 1";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		$result->MoveFirst();
		return (int) $result->fields["cnt"] > 0 ? true : false;
    }
		
	public function traerOrdenTurno($maquina, $turno){
		$sql = 	"SELECT orden_produccion 
				 FROM turnos
				 WHERE id_proceso = '$maquina' AND id_turno = '$turno' AND terminado = '0'";
				 
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
		if ($result === false) die("fallo consulta");
		$conexion_pg->Close();
		return $result->fields[0];
	}

    public function traerDatosTurno($maquina) {
		$sql = "SELECT p.id_proceso maquina,
					p.descripcion nom_maquina,
					t.id_turno turno,
					CASE WHEN (tp.terminado IS NULL) THEN 0 ELSE (case when (tp.terminado = 0) then 1 else 0 end) END enParo,
					t.unidades_conteo unidades,
					t.indicador_1 disponibilidad,
					t.indicador_2 velocidad,
					t.indicador_4 estimado,
					case when (t.terminado = 0) then 1 else 0 end estadoTurno
				FROM procesos p
					LEFT JOIN turnos t ON p.id_proceso = t.id_proceso AND t.id_turno = p.batch	
					LEFT JOIN turno_parada tp ON t.id_turno = tp.id_turno AND t.id_proceso = tp.id_proceso AND tp.terminado = 0
				WHERE p.id_proceso = '$maquina'";
		include("conexion.php");
	    $result = $conexion_pg->Execute($sql);
        if ($result === false)
            die("fallo consulta");
        $conexion_pg->Close();
		
		$unidades = round($result->fields["unidades"],1);
		
		return array(
			'maquina' 			=> $result->fields["maquina"],
			'nom_maquina'		=> $result->fields["nom_maquina"],
			'turno' 			=> $result->fields["turno"],
			'enParo' 			=> $result->fields["enparo"],
			'unidades' 			=> $unidades,
			'disponibilidad' 	=> $result->fields["disponibilidad"],
			'velocidad' 		=> $result->fields["velocidad"],
			'estimado' 			=> $result->fields["estimado"],
			'estadoTurno' 		=> $result->fields["estadoturno"]
		);
    }

    public function traerDatosParada($maquina) {
		$sql = "SELECT pro.id_proceso maquina,
					pro.descripcion nom_maquina,
					pro.batch turno,
					CASE WHEN (tp.terminado = 0) THEN 1 ELSE 0 END enparo,
					CASE WHEN (tp.id_parada = '999') THEN 0 ELSE 1 END registrada,
					tp.horas tiempo,
					CASE WHEN (t.terminado = 0) THEN 1 ELSE 0 END estadoturno,
					p.nombre_parada causal,
					tp.id_parada parada
				FROM procesos pro
					LEFT JOIN turnos t ON pro.id_proceso = t.id_proceso AND t.terminado = 0
					LEFT JOIN turno_parada tp ON t.id_proceso = tp.id_proceso AND t.id_turno = tp.id_turno AND tp.terminado = 0
					LEFT JOIN paradas p ON p.id_parada = tp.id_parada
				WHERE pro.id_proceso = '$maquina'";
		include("conexion.php");
	    $result = $conexion_pg->Execute($sql);
        if ($result === false)
            die("fallo consulta");
        $conexion_pg->Close();
		
		$tiempo = $this->tiempo_segundos($result->fields["tiempo"]);

		return array(
			'maquina' 			=> $result->fields["maquina"],
			'nom_maquina'		=> $result->fields["nom_maquina"],
			'turno' 			=> $result->fields["turno"],
			'enParo' 			=> $result->fields["enparo"],
			'registrada' 		=> $result->fields["registrada"],
			'causal' 			=> $result->fields["causal"],
			'tiempo' 			=> $tiempo,
			'estadoTurno' 		=> $result->fields["estadoturno"],
			'parada'			=> $result->fields["parada"],
		);
    }
	
	function tiempo_segundos($segundos)
	{
		$minutos=$segundos/60;
		$horas=floor($minutos/60);
		$minutos2=$minutos%60;
		$segundos_2=$segundos%60%60%60;
		if($minutos2<10)$minutos2='0'.$minutos2;
		if($segundos_2<10)$segundos_2='0'.$segundos_2;
	
		if($segundos<60){ /* segundos */
			$resultado= '00:00:'.round($segundos);
		}
		elseif($segundos>60 && $segundos<3600){/* minutos */
			$resultado= '00:'.$minutos2.':'.$segundos_2;
		}
		else{/* horas */
			if($horas<10)
			{
				$horas='0'.$horas;
			}
			$resultado= $horas.":".$minutos2.":".$segundos_2;
		}
		return $resultado;
	}
	
	public function getTurnoMaquina($maquina){
		$sql ="SELECT batch FROM procesos WHERE id_proceso ='$maquina'";
        include("conexion.php");
        $result = $conexion_pg->Execute($sql);
        if ($result === false) die("fallo consulta");
        $conexion_pg->Close();
		return $result->fields["batch"]; 
	}
	
    public function iniciarTurno($turno) {
		
		$fecha=date("Y-m-d H:i:s");
		$maquina 	= $turno["maquina"];
		$op 		= $turno["op"];
		$producto 	= $turno["producto"];
		$lote 		= $turno["lote"];
		$maqturno	= $this->getTurnoMaquina($maquina);
		
		//preguntar si el turno que quiero abrir ya fue abierto
		
		$datos_turno = $this->traerDatosTurno($maquina);//el campo estadoTurno retorna 1 si hay un turno abierto para la maquina
		if($datos_turno['estadoTurno'] == 0){
		
			//preguntar si el turno que quiero abrir ya esta cerrado
			
			$turnocerrado = $this->validarTurnoCerrado($maquina, $maqturno); //true si el turno que estoy tratando de abrir esta cerrado
			if($turnocerrado) $this->aumentarTurno($maquina);
			
			//
			$maqturno	= $this->getTurnoMaquina($maquina);
			
			$sql = "INSERT INTO turnos (id_turno,id_proceso,id_producto,orden_produccion,dato_extra,fecha_inicio,fecha_fin) values ('$maqturno','$maquina','$producto','$op','$lote','$fecha','$fecha')";
			include("conexion.php");
			if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
			
			$operarios = $turno["operario"];
			foreach($operarios as $operario){
				$sql = "INSERT INTO turno_asistencia (id_turno,id_proceso,id_empleado,fecha_inicio,fecha_fin) values ('$maqturno','$maquina','$operario','$fecha','$fecha')";
				if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
			}
			
			$conexion_pg->Close();
		}
			return array(
				'maquina' => $maquina,
				'turno' => $maqturno,
				'estadoTurno' => 1 //1 = abierto, 2= cerrado
			);
		
		
    }

	public function aumentarTurno($maquina)
	{
		$maqturno = $this->getTurnoMaquina($maquina);
		
		$sql = "UPDATE procesos 
				SET	batch=".($maqturno+1)."
				WHERE id_proceso='$maquina'";
				
		include("conexion.php");
        if ($conexion_pg->Execute($sql) === false)
            die("fallo consulta");
        $conexion_pg->Close();
	}
	
    public function registrarParada($maquina,$codigo) {
        //registra parada con $codigo
		//si la parada actual tiene el codigo 999, actualizar el codigo; si la parada actual tiene cualquier codigo distinto a 999 cerrar la parada e iniciar
		//una nueva parada con el codigo enviado.		
		if($this->validarParada($codigo)){
			
			$fecha=date("Y-m-d H:i:s");
			$datosparada = $this->traerDatosParada($maquina);
			$maqturno = $this->getTurnoMaquina($maquina);
			$paradaactual = $datosparada["parada"];
			$fecha_inicio = $this->fecha_parada($maqturno,$maquina);
			$intervalo_segundos = $this->diferencia_tiempo_segundos($fecha_inicio);
			$intervalo_hora = $this->tiempo_segundos($intervalo_segundos);//el mismo dato de "intervalo_segundos" pero en formato hh:mm:ss
			
			
			include("conexion.php");
			if($paradaactual == "999"){
				$sql = "UPDATE turno_parada SET id_parada = '$codigo', fecha_fin = '$fecha' WHERE id_proceso = '$maquina' AND id_turno = '$maqturno' and terminado = '0'";
				if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
			}
			else{
				
				//primero se cierra la parada abierta
				$sql = "UPDATE turno_parada SET fecha_fin='$fecha',horas='$intervalo_segundos',terminado='1', intervalo_horas='$intervalo_hora' WHERE id_proceso = '$maquina' AND id_turno = '$maqturno' and terminado = '0'";
				if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
				
				//acontinuacion se abre una nueva con el codigo que se envia
				$sql = "INSERT INTO turno_parada (id_turno,id_proceso,id_parada,fecha_inicio) VALUES ('$maqturno','$maquina','$codigo','$fecha')";
				if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
			}
			$conexion_pg->Close();
			return true;
		}
		else{
			return false;
		}
    }
	public function diferencia_tiempo_segundos($fecha_inicio) //la fecha de inicio de la parada
	{
		include("fechas.php");
		$fechas = new conversiones_fechas();
		
		$fechaactual= date("Y-m-d H:i:s");
		$fechainial = date($fecha_inicio);
		$intervalo=$fechas->getDifFechastodo($fechaactual,$fechainial);
		
		return ($intervalo);
	}

	public function fecha_parada($turno, $maquina)
	{
		$sql = "SELECT *
				FROM turno_parada 
				WHERE id_turno='$turno' AND terminado ='0' AND id_proceso='$maquina'";
		include("conexion.php");
		$result = $conexion_pg->Execute($sql);
        if ($result === false)
            die("fallo consulta");
        $conexion_pg->Close();
		return $result->fields["fecha_inicio"];
	}
	
	public function cerrarTurno($turno) {
        
		//DATOS DEL CIERRE DE TURNO
		$fechaactual= date("Y-m-d H:i:s");
		$maquina = $turno['maquina'];
		$maqturno = $this->getTurnoMaquina($maquina);
		$desperdicio1 = $turno['materiales'][0];
		$desperdicio2 = $turno['materiales'][1];
		$desperdicio3 = $turno['materiales'][2];
		$prod_final = $turno['pruduccionFinal'];
		$orden_turno = $this->traerOrdenTurno($maquina, $maqturno);
					
		//ante todo se deben cerrar las paradas abiertas del turno
		$sql = "UPDATE turno_parada 
				SET	terminado = '1'
				WHERE id_proceso = '$maquina'";
		
		include("conexion.php");
		if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
		$conexion_pg->Close();
		
		//Acontinuación se guardan las unidades terminadas
		$sql = 	"UPDATE ordenes_produccion 
				SET	cant_terminada = cant_terminada + $prod_final,
					terminada = CASE WHEN (cant_terminada + $prod_final) >= cantidad THEN 1 ELSE 0 END 
				WHERE id_orden_produccion = $orden_turno";
					
		include("conexion.php");
		if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
		$conexion_pg->Close();
		
		//y finalmente se cierra el turno
		$sql = "UPDATE turnos 
				SET	fecha_fin = '$fechaactual',
					desperdicio_1 = '$desperdicio1',
					desperdicio_2 = '$desperdicio2',
					desperdicio_3 = '$desperdicio3',
					produccion_final = '$prod_final',
					terminado = '1'
				WHERE id_turno='$maqturno' 
					AND id_proceso='$maquina'
					AND terminado ='0'";
					
		include("conexion.php");
		if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
		$conexion_pg->Close();
		
		//tambien se debe cerrar la asistencia del turno
		$sql = "UPDATE turno_asistencia 
				SET	fecha_fin = '$fechaactual',
					teminado = 1
				WHERE id_turno='$maqturno' 
					AND id_proceso='$maquina'
					AND teminado = 0";
					
		include("conexion.php");
		if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
		$conexion_pg->Close();			
		
		return true;
    }
	
	public function sacarUsuario($usuario, $maquina){
		$maqturno = $this->getTurnoMaquina($maquina);
		$fechaactual= date("Y-m-d H:i:s");
		
		$sql = "UPDATE turno_asistencia 
				SET	fecha_fin = '$fechaactual',
					teminado = 1
				WHERE id_proceso = $maquina 
					AND id_turno = $maqturno
					AND id_empleado = $usuario";
		
		include("conexion.php");
		if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
		$conexion_pg->Close();
		
		return true;
	}
	
	public function validarEspacio($maquina, $maqturno){		
		$actuales=0;//en esta variable se guardara la cantidad de personas registradas actualmente
		$permitido=0;//en esta variable se guarda la cantidad de operarios que la maquina solicita		
		include("conexion.php");
		$sql = "SELECT count(*) cnt 
				FROM turno_asistencia 
				WHERE id_turno = $maqturno
					AND id_proceso = $maquina
					AND teminado = 0";
		$result = $conexion_pg->Execute($sql);
        if ($result === false)die("fallo consulta");
		
		$actuales = $result->fields["cnt"];
				
		$sql = "SELECT cant_operarios cnt 
				FROM procesos 
				WHERE id_proceso = $maquina";
		$result = $conexion_pg->Execute($sql);
        if ($result === false)
            die("fallo consulta");
        $conexion_pg->Close();		
		$permitido = $result->fields["cnt"];

		if($actuales < $permitido){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function ingresarUsuario($usuario, $maquina){
		$maqturno = $this->getTurnoMaquina($maquina);
		$fechaactual= date("Y-m-d H:i:s");

		if($this->validarEspacio($maquina,$maqturno)){
			include("conexion.php");
			$sql = "INSERT INTO turno_asistencia (id_turno,id_proceso,id_empleado,fecha_inicio,fecha_fin) values ($maqturno,$maquina,$usuario,'$fechaactual','$fechaactual')";
			if ($conexion_pg->Execute($sql) === false) die("fallo consulta");
			$conexion_pg->Close();
			
			return true;
		}
		else{
			return false;
		}
	}
	
	public function calcular_indicadores($maquina, $turno)
	{
		include("fechas.php");
		$fechas = new conversiones_fechas();
		
		$sql ="SELECT 	coalesce(t.indicador_1, '1') indicador_1,
						coalesce(t.indicador_2, '1') indicador_2,
						coalesce(t.indicador_3, '1') indicador_3,
						coalesce(t.indicador_4, '1') indicador_4,
						coalesce(t.indicador_5, '1') indicador_5,
						coalesce(t.indicador_6, '1') indicador_6,
						coalesce(t.indicador_7, '1') indicador_7,
						coalesce(t.tiempo_maquina, 1) tiempo_maquina,
						coalesce(t.unidades_conteo, '1') unidades_conteo,
						coalesce(t.tiempo_hombre, 1) tiempo_hombre,
						coalesce(t.tiempo_turno, 1) tiempo_turno,
						coalesce(t.tiempo_paro_prog, 1) tiempo_paro_prog,
						coalesce(t.tiempo_paro_no_p, 1) tiempo_paro_no_p,
						coalesce(t.tiempo_paro_g1, 1) tiempo_paro_g1,
						coalesce(t.tiempo_paro_g2, 1) tiempo_paro_g2,
						coalesce(t.tiempo_paro_g3, 1) tiempo_paro_g3,
						coalesce(t.tiempo_total_paro, 1) tiempo_total_paro,
						coalesce(t.tiempo_std_prog, 1) tiempo_std_prog,
						coalesce(t.dato_extra, 1) dato_extra,
						coalesce(t.desperdicio_1, 1)desperdicio_1,
						coalesce(t.desperdicio_2, 1)desperdicio_2,
						coalesce(t.desperdicio_3, 1)desperdicio_3,
						coalesce(t.produccion_final, 1) produccion_final,
						coalesce(pp.var1, '1') var1,
						coalesce(pp.var2, '1') var2,
						coalesce(pp.var3, '1') var3,
						coalesce(p.dato_extra1, '1') dato_extra1,
						coalesce(p.dato_extra2, '1') dato_extra2,
						coalesce(p.dato_extra3, '1') dato_extra3
				FROM turnos AS t
					LEFT JOIN producto_proceso pp ON pp.id_proceso = t.id_proceso AND pp.id_producto = t.id_producto 
					LEFT JOIN productos p ON p.id_producto=t.id_producto
				WHERE t.id_proceso='$maquina' AND t.id_turno = '$turno'";

		include("conexion.php");
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
			$formulas_r[$i]=str_replace("desperdicio3",$variables->fields["desperdicio_2"],$formulas_r[$i]);
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
				WHERE id_proceso='$maquina' AND id_turno = '$turno'";
		
		include("conexion.php");
        if ($conexion_pg->Execute($sql) === false)
            die("fallo consulta");		
		$conexion_pg->Close();
	}
	
	function listar_procesos(){
		include("conexion.php");
		$sql =	"SELECT p.nombre nombre,
					p.id_proceso id_proceso,
					coalesce(t.terminado,1) t_terminado,
					coalesce(tp.terminado,1) tp_terminado
				FROM procesos p
					LEFT JOIN turnos t ON t.id_proceso = p.id_proceso AND t.id_turno = p.batch
					LEFT JOIN (SELECT id_turno id_turno,
							id_proceso id_proceso,
							terminado terminado,
							max(id_turno_parada)
						FROM turno_parada
						GROUP BY id_proceso, id_turno, terminado) tp ON t.id_turno = tp.id_turno AND t.id_proceso = tp.id_proceso AND tp.terminado = 0
				WHERE p.estado = 1
				ORDER BY id_proceso";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}
	
	function guardar_observaciones($turno){
		$maquina = $turno['maquina'];
		$observaciones = $turno['observaciones'];
		$maqturno = $this->getTurnoMaquina($maquina);
		
		include("conexion.php");
		$sql =	"UPDATE turnos SET obsevaciones = '$observaciones' WHERE id_proceso = $maquina AND id_turno = $maqturno";
		echo 'error al listar: '.$observaciones.'<BR>';
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		
		//$this->calcular_indicadores($maquina, $maqturno);
		
		return true;
	}
	
    public function traerDatosDesperdicios() {
		$sql = "SELECT *
				FROM variables etq
				WHERE id_variable in (13, 14, 15)";
		include("conexion.php");
	    $result = $conexion_pg->Execute($sql);
        if ($result === false)
            die("fallo consulta");
        $conexion_pg->Close();
		$indice = 0;
		$datos = array();
		while(!$result->EOF){
			$datos[$indice] = $result->fields["etiqueta"];
			$indice++;
			$result->MoveNext();
		}
		return array(
			'desp1'	=> $datos[0],
			'desp2'	=> $datos[1],
			'desp3'	=> $datos[2]
		);
    }
}

?>
