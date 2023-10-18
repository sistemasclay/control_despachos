<?php
include("clases/reportes_excel.php");
$repor= new reportes_excel();

//echo $_POST["id_proceso"];
$fechai=$_POST["fechai"];
$fechaf=$_POST["fechaf"];

	$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
	$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";     	
	
switch ($_POST["tipo"])
{
	case "1":
		$sql_datos = "SELECT prod.id_producto id_producto,
								prod.nombre_producto nombre_producto,
								ctm.id_t_muestreo id_t_muestreo,
								cproc.id_proceso id_proceso,
								cproc.nombre nombre_proceso,
								cprov.id_proveedor id_proveedor,
								cprov.nombre_proveedor nombre_proveedor,
								per.nombre_persona nombre_persona,
								cr.id_registro id_registro,
								cr.ts_registro ts_registro,
								cr.lote lote,
								cr.orden_produccion orden,
								crp.id_parametro id_parametro,
								crp.medida medida,
								crf.id_fallo id_fallo
						FROM cal_turno_muestreo ctm
							INNER JOIN productos prod ON prod.id_producto = ctm.id_producto
							INNER JOIN cal_registros cr ON cr.id_turno_muestreo = ctm.id_t_muestreo
							INNER JOIN personal per ON per.id_persona = cr.id_usuario
							LEFT JOIN cal_procesos cproc ON cproc.id_proceso = cr.id_maquina
							LEFT JOIN cal_proveedores cprov ON cprov.id_proveedor = cr.id_proveedor
							LEFT JOIN cal_registro_parametros crp ON crp.id_registro = cr.id_registro
							LEFT JOIN cal_registro_fallos crf ON crf.id_registro = cr.id_registro
						WHERE (ctm.fecha_inicio between '".$_POST["fechai"]."' AND '".$_POST["fechaf"]."')
							AND ctm.id_producto = ".$_POST["id_producto"]."
						ORDER BY ctm.id_t_muestreo, cr.id_registro, crp.id_parametro, crf.id_fallo";
		
		$sql_parametros = "SELECT cpar.* 
							FROM cal_parametros cpar 
								INNER JOIN cal_estandar_producto cep ON cep.id_parametro = cpar.id_parametro AND cep.id_producto = ".$_POST["id_producto"]."
							ORDER BY cep.id_parametro";
		
		$sql_defectos = "SELECT cf.* 
						FROM cal_fallos cf
							INNER JOIN cal_estandar_fallos cef ON cef.id_fallo = cf.id_fallo AND cef.id_producto = ".$_POST["id_producto"]."
						WHERE cf.cuantificable = 0";
		
		$repor->excel_bitacora($sql_datos, $sql_parametros, $sql_defectos, $fechai, $fechaf);
		
	break;
	
	case "2":
		
		//GRAFICA X-R == GRAFICA DE RANGOS
		$sql_datos = "SELECT cr.id_registro id_registro,
							crp.medida medida,
							crp.id_parametro id_parametro,
							cpar.nombre_parametro nombre_parametro,
							cep.limite_inf_espec limite_inf_espec,
							cep.limite_inf_control limite_inf_control,
							cep.limite_sup_control limite_sup_control,
							cep.limite_sup_espec limite_sup_espec,
							prod.nombre_producto nombre_producto
						FROM cal_turno_muestreo ctm
							INNER JOIN productos prod ON prod.id_producto = ctm.id_producto
							INNER JOIN cal_registros cr ON cr.id_turno_muestreo = ctm.id_t_muestreo
							LEFT JOIN cal_registro_parametros crp ON crp.id_registro = cr.id_registro
							LEFT JOIN cal_estandar_producto cep ON cep.id_parametro = crp.id_parametro AND cep.id_producto = crp.id_producto
							LEFT JOIN cal_parametros cpar ON cpar.id_parametro = crp.id_parametro
						WHERE (ctm.fecha_inicio BETWEEN '".$_POST["fechai"]."' AND '".$_POST["fechaf"]."')
							AND ctm.id_producto = ".$_POST["id_producto"]."
						ORDER BY crp.id_parametro, cr.id_registro";		
		$repor->pdf_grafico_rangos($sql_datos, $fechai, $fechaf);
		
	break;
	
	case "3":
		
		//GRAFICA DE OCURRENCIA DE ERRORES
		$sql_datos = "SELECT id_fallo
						FROM cal_registro_fallos crf
							INNER JOIN cal_registros cr ON cr.id_registro = crf.id_registro
						WHERE (cr.ts_registro BETWEEN '".$_POST["fechai"]."' AND '".$_POST["fechaf"]."')
							AND cr.id_producto = ".$_POST["id_producto"]."";
		$repor->pdf_grafico_ocurrencias($sql_datos, $_POST["id_producto"],$fechai, $fechaf);
		
	break;
}
?>

