<?
ini_set('memory_limit','1024M');
include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");

class reportes_excel {
    //put your code here

	function tiempo_segundos($segundos)
	{
		$minutos=$segundos/60;
		$horas=floor($minutos/60);
		$minutos2=$minutos%60;
		$segundos_2=$segundos%60%60%60;
		if($minutos2<10)$minutos2='0'.$minutos2;
		if($segundos_2<10)$segundos_2='0'.$segundos_2;
		if($segundos<60) /* segundos */
		{
			$resultado= '00:00:'.round($segundos);
			/*   if($segundos<10)
			{$resultado=$resultado.'0';} */
		}
		elseif($segundos>60 && $segundos<3600) /* minutos */
		{
			$resultado= '00:'.$minutos2.':'.$segundos_2;
		}
		else /* horas */
		{
			if($horas<10){$horas='0'.$horas;}
			$resultado= $horas.":".$minutos2.":".$segundos_2;
		}
		return $resultado;
	}

	function grupo_paro($grupo)
	{
		$nombre_grupo="";
		switch ($grupo)
		{
			case "1":
				$nombre_grupo="Averias";
			break;
			case "2":
				$nombre_grupo="Cuadre y Ajuste";
			break;
			case "3":
				$nombre_grupo="Pequena Parada";
			break;
		}
	return $nombre_grupo;
	}

    function listar_turno_paradas($id_turno,$id_proceso)
    {
		include("conexion.php");
		$sql = "SELECT *
				FROM turno_parada as a INNER JOIN paradas as b ON (a.id_parada= b.id_parada) WHERE id_turno='".$id_turno."' AND id_proceso='".$id_proceso."' order by fecha_inicio";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}


	function listar_etiquetas()
	{
		include("conexion.php");
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

	function listar_turno_asistencia($id_turno,$id_proceso)
	{
		include("conexion.php");
		// $sql =	"SELECT * FROM ordenes_produccion";
		$sql = "SELECT *
				FROM turno_asistencia as a 
					INNER JOIN personal as b ON (a.id_empleado= b.id_persona)
				WHERE id_turno='".$id_turno."' AND id_proceso='".$id_proceso."'";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
    }

	function excel_produccion_operario($sql,$maquina)
	{
		$etiquetas=$this->listar_etiquetas();
		include("conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		/** Error reporting */
		error_reporting(E_ALL);
		
		/** PHPExcel */
		require_once '../clases/PHPExcel.php';
		
		/** PHPExcel_IOFactory */
		require_once '../clases/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control")
									->setLastModifiedBy("Monitoreo y Control")
									->setTitle("Reporte Produccion por Operario")
									->setSubject("Reporte Produccion por Operario")
									->setDescription("Reporte Produccion por Operario Pegasus PRO")
									->setKeywords("office 2007 openxml php")
									->setCategory("Informe");
										
		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,2, "Reporte Produccion por Operario; Proceso: ".$result->fields['maquina']);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(12);//TURNO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);//MAQUINA
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(35);//PRODUCTO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(30);//OPERARIO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(18);//FECHA INICIAL
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(18);//FECHA FINAL
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(20);//UNIDADES
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(20);//PRODUCCIÓN FINAL
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);//OEE
		
		// agregar cabeceras
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,5, 'TURNO')
					->setCellValueByColumnAndRow(1,5, 'MAQUINA')
					->setCellValueByColumnAndRow(2,5, 'PRODUCTO')
					->setCellValueByColumnAndRow(3,5, 'OPERARIO')
					->setCellValueByColumnAndRow(4,5, 'FECHA INICIAL')
					->setCellValueByColumnAndRow(5,5, 'FECHA FINAL')
					->setCellValueByColumnAndRow(6,5, 'UNIDADES')
					->setCellValueByColumnAndRow(7,5, 'PRODUCCIÓN FINAL')
					->setCellValueByColumnAndRow(8,5, 'OEE');
					
		$i='A';
		while($i!='J'){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($i.'5')->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
			++$i;
		}
		$i=6;
		while (!$result->EOF)
		{
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$i,$result->fields['turno'])
						->setCellValueByColumnAndRow(1,$i,$result->fields['maquina'])
						->setCellValueByColumnAndRow(2,$i,$result->fields['producto'])
						->setCellValueByColumnAndRow(3,$i,$result->fields['operario'])
						->setCellValueByColumnAndRow(4,$i,$result->fields['fecha_i'])
						->setCellValueByColumnAndRow(5,$i,$result->fields['fecha_f'])
						->setCellValueByColumnAndRow(6,$i,$result->fields['inyecciones'])
						->setCellValueByColumnAndRow(7,$i,$result->fields['produccion'])
						->setCellValueByColumnAndRow(8,$i,$result->fields['oee']);
			$j='A';
			while($j!='J'){
				if($j=='A' || $j=='G' || $j=='H' || $j=='I'){
					$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																	'alignment' => array(
																		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
																	)																
																)
															);
				}
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																	'borders' => array(
																		'allborders' => array(
																			'style' => PHPExcel_Style_Border::BORDER_THIN
																		)
																	)																
																)
															);
				++$j;
			}
			$i++;
			$result->MoveNext();
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('REPORTE PRODUCCIÓN OPERARIO');
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PEGASUS PRO LOGO');
		$objDrawing->setDescription('PEGASUS PRO LOGO');
		$objDrawing->setPath('../logo.png');
		$objDrawing->setHeight(30);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(0);
		$objDrawing->setOffsetY(0);
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="REPORTE PRODUCCIÓN OPERARIO.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    }

	function excel_consumo_Energético($sql,$maquina)
    {
		$etiquetas=$this->listar_etiquetas();
		include("conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		/** Error reporting */
		error_reporting(E_ALL);
		
		/** PHPExcel */
		require_once '../clases/PHPExcel.php';
		
		/** PHPExcel_IOFactory */
		require_once '../clases/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control")
									->setLastModifiedBy("Monitoreo y Control")
									->setTitle("Reporte de Consumo Energético")
									->setSubject("Reporte de Consumo Energético")
									->setDescription("Reporte de Consumo Energético Pegasus PRO")
									->setKeywords("office 2007 openxml php")
									->setCategory("Informe");
										
		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,2, "Reporte de Consumo Energético de la Máquina ".$result->fields['maquina']);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(12);//TURNO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);//MAQUINA
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(35);//PRODUCTO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(18);//VAR2
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(18);//HORAS
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);//CONSUMO
		
		// agregar cabeceras
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,5, 'TURNO')
					->setCellValueByColumnAndRow(1,5, 'MAQUINA')
					->setCellValueByColumnAndRow(2,5, 'PRODUCTO')
					->setCellValueByColumnAndRow(3,5, $etiquetas[27]["etiqueta"])
					->setCellValueByColumnAndRow(4,5, 'HORAS')
					->setCellValueByColumnAndRow(5,5, 'CONSUMO');
					
		$i='A';
		while($i!='G'){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($i.'5')->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
			++$i;
		}
		$i=6;
		$total = 0;
		while (!$result->EOF)
		{
			$horas = round(($result->fields['tiempo']/3600),2);
			$consumo = round(($result->fields['var2']*$horas),2);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$i,$result->fields['turno'])
						->setCellValueByColumnAndRow(1,$i,$result->fields['maquina'])
						->setCellValueByColumnAndRow(2,$i,$result->fields['producto'])
						->setCellValueByColumnAndRow(3,$i,$result->fields['var2'])
						->setCellValueByColumnAndRow(4,$i,$horas)
						->setCellValueByColumnAndRow(5,$i,$consumo);
			$j='A';
			while($j!='G'){
				if($j=='A' || $j=='D' || $j=='E' || $j=='F'){
					$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																	'alignment' => array(
																		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
																	)																
																)
															);
				}
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																	'borders' => array(
																		'allborders' => array(
																			'style' => PHPExcel_Style_Border::BORDER_THIN
																		)
																	)																
																)
															);
				++$j;
			}
			$i++;
			if($result->fields['var2']!=0 || $result->fields['var2']!=''){
				$total = $total + $consumo;
			}
			$result->MoveNext();
		}
		
		$i = $i + 1;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(4,$i,'CONSUMO TOTAL')
					->setCellValueByColumnAndRow(5,$i,$total);
		
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$i)->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.$i)->applyFromArray(
												array(
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
		
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('REPORTE CONSUMO Energético');
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PEGASUS PRO LOGO');
		$objDrawing->setDescription('PEGASUS PRO LOGO');
		$objDrawing->setPath('../logo.png');
		$objDrawing->setHeight(30);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(0);
		$objDrawing->setOffsetY(0);
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="REPORTE CONSUMO Energético.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    }

	function excel_unidades_horario($sql,$maquina)
    {
		$etiquetas=$this->listar_etiquetas();
		include("conexion.php");
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		/** Error reporting */
		error_reporting(E_ALL);
		
		/** PHPExcel */
		require_once '../clases/PHPExcel.php';
		
		/** PHPExcel_IOFactory */
		require_once '../clases/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control")
									->setLastModifiedBy("Monitoreo y Control")
									->setTitle("Reporte de Unidades por Horaios")
									->setSubject("Reporte de Unidades por Horaios")
									->setDescription("Reporte de Unidades por Horaios Pegasus PRO")
									->setKeywords("office 2007 openxml php")
									->setCategory("Informe");
										
		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,2, "Reporte de Produccion por Horarios ".$result->fields['maquina']);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(18);//TURNO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);//MAQUINA
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(35);//PRODUCTO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(18);//VAR2
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(18);//HORAS
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);//CONSUMO
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(20);//CONSUMO
		
		// agregar cabeceras
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,5, 'TURNO')
					->setCellValueByColumnAndRow(1,5, 'MAQUINA')
					->setCellValueByColumnAndRow(2,5, 'PRODUCTO')
					->setCellValueByColumnAndRow(3,5, 'HORARIO')
					->setCellValueByColumnAndRow(4,5, 'UNIDADES')
					->setCellValueByColumnAndRow(5,5, 'PRODUCCION')
					->setCellValueByColumnAndRow(6,5, 'OEE');
					
		$i='A';
		while($i!='H'){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($i.'5')->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
			++$i;
		}
		$i=6;
		//VARIABLES QUE REPRESENTAN LAS SUMATORIAS POR HORARIOS DE LAS UNIDADES PRODUCIDAS
		$total1 = 0;
		$total2 = 0;
		$total3 = 0;
		$total4 = 0;
		$total5 = 0;
		//VARIABLES QUE REPRESENTAN LAS SUMATORIAS POR HORARIOS DE OEE X TIEMPO
		$oeeXtiempo1 = 0;
		$oeeXtiempo2 = 0;
		$oeeXtiempo3 = 0;
		$oeeXtiempo4 = 0;
		$oeeXtiempo5 = 0;
		//VARIABLES QUE REPRESENTAN LAS SUMATORIAS POR HORARIOS DE LOS TIEMPOS DE TURNOS
		$tt1 = 1;
		$tt2 = 1;
		$tt3 = 1;
		$tt4 = 1;
		$tt5 = 1;
		while (!$result->EOF)
		{
			$horario = "";
			$sum_oee = $result->fields['tiempo'] * $result->fields['oee'];
			IF($result->fields['horario'] == 1){
				$total1 = $total1 + $result->fields['produccion'];
				$oeeXtiempo1 = $oeeXtiempo1 + $sum_oee;
				$tt1 = $tt1 + $result->fields['tiempo'];
				$horario = "MAÑANA";
			}
			IF($result->fields['horario'] == 2){
				$total2 = $total2 + $result->fields['produccion'];
				$oeeXtiempo2 = $oeeXtiempo2 + $sum_oee;
				$tt2 = $tt2 + $result->fields['tiempo'];
				$horario = "TARDE";
			}
			IF($result->fields['horario'] == 3){
				$total3 = $total3 + $result->fields['produccion'];
				$oeeXtiempo3 = $oeeXtiempo3 + $sum_oee;
				$tt3 = $tt3 + $result->fields['tiempo'];
				$horario = "NOCHE";
			}
			IF($result->fields['horario'] == 4){
				$total4 = $total4 + $result->fields['produccion'];
				$oeeXtiempo4 = $oeeXtiempo4 + $sum_oee;
				$tt4 = $tt4 + $result->fields['tiempo'];
				$horario = "ESPECIAL1";
			}
			IF($result->fields['horario'] == 5){
				$total5 = $total5 + $result->fields['produccion'];
				$oeeXtiempo5 = $oeeXtiempo5 + $sum_oee;
				$tt5 = $tt5 + $result->fields['tiempo'];
				$horario = "ESPECIAL2";
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$i,$result->fields['turno'])
						->setCellValueByColumnAndRow(1,$i,$result->fields['maquina'])
						->setCellValueByColumnAndRow(2,$i,$result->fields['producto'])
						->setCellValueByColumnAndRow(3,$i,$result->fields['horario'])
						->setCellValueByColumnAndRow(4,$i,$result->fields['unidades'])
						->setCellValueByColumnAndRow(5,$i,$result->fields['produccion'])
						->setCellValueByColumnAndRow(6,$i,$result->fields['oee']);
			$j='A';
			while($j!='H'){
				if($j=='A' || $j=='G' || $j=='E' || $j=='F'){
					$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																	'alignment' => array(
																		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
																	)																
																)
															);
				}
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($j.$i)->applyFromArray(
															array(
																'borders' => array(
																	'allborders' => array(
																		'style' => PHPExcel_Style_Border::BORDER_THIN
																	)
																)																
															)
														);
				++$j;
			}		
			
			$i++;
			
			$result->MoveNext();
		}
		
		$i = $i + 1;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1,$i,'TOTAL MAÑANA')
					->setCellValueByColumnAndRow(2,$i,'TOTAL TARDE')
					->setCellValueByColumnAndRow(3,$i,'TOTAL NOCHE')
					->setCellValueByColumnAndRow(4,$i,'TOTAL ESPECIAL1')
					->setCellValueByColumnAndRow(5,$i,'TOTAL ESPECIAL2');
		$i++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$i,'UNIDADES BUENAS')
					->setCellValueByColumnAndRow(1,$i,$total1)
					->setCellValueByColumnAndRow(2,$i,$total2)
					->setCellValueByColumnAndRow(3,$i,$total3)
					->setCellValueByColumnAndRow(4,$i,$total4)
					->setCellValueByColumnAndRow(5,$i,$total5);
		$i++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$i,'OEE PROMEDIO')
					->setCellValueByColumnAndRow(1,round($oeeXtiempo1/$tt1,2))
					->setCellValueByColumnAndRow(2,round($oeeXtiempo2/$tt2,2))
					->setCellValueByColumnAndRow(3,round($oeeXtiempo3/$tt3,2))
					->setCellValueByColumnAndRow(4,round($oeeXtiempo4/$tt4,2))
					->setCellValueByColumnAndRow(5,round($oeeXtiempo5/$tt5,2));
		/*
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$i)->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.$i)->applyFromArray(
												array(
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
		*/
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('REPORTE UNIDADES POR HORARIO');
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PEGASUS PRO LOGO');
		$objDrawing->setDescription('PEGASUS PRO LOGO');
		$objDrawing->setPath('../logo.png');
		$objDrawing->setHeight(30);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(0);
		$objDrawing->setOffsetY(0);
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="REPORTE UNIDADES POR HORARIO.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    }
	
	function excel_horas_por_dia_maquina($sql1,$sql2,$fechai,$fechaf)
    {
		/*
		*$result1: es el resultado del sql que pide los datos que se van a poner en el reporte
		*$result2: es el resultado del sql que pide los datos de las máquinas
		*/
		$etiquetas=$this->listar_etiquetas();
		include("conexion.php");
		$result1=$conexion_pg->Execute($sql1);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		
		$result2=$conexion_pg->Execute($sql2);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		/** Error reporting */
		error_reporting(E_ALL);
		
		/** PHPExcel */
		require_once '../clases/PHPExcel.php';
		
		/** PHPExcel_IOFactory */
		require_once '../clases/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		$estilodatos = new PHPExcel_Style();
		$estilodatos->applyFromArray(
							array(
								'font'  => array(
										'size'  => 12,
										'name'  => 'Calibri'
								),
								'borders' => array(
									'allborders' => array(
										'style' => PHPExcel_Style_Border::BORDER_THICK
									)
								), 
								'alignment' =>  array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
										'rotation'   => 0,
										'wrap'		 => TRUE
								)
							)
						);
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control")
									->setLastModifiedBy("Monitoreo y Control")
									->setTitle("Reporte de Horas Trabajadas Diarias por Máquinas")
									->setSubject("Reporte de Horas Trabajadas Diarias por Máquinas")
									->setDescription("Reporte de Horas Trabajadas Diarias por Máquinas")
									->setKeywords("office 2007 openxml php")
									->setCategory("Informe");
										
		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,2, "Horas de Trabajo Diarias por Máquinas");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E2')->applyFromArray(
												array(
													'font'  => array(
														'size'  => 14,
														'name'  => 'Calibri'
													)
												)
											);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,4, "Desde ".$fechai.", Hasta ".$fechaf);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('F4')->applyFromArray(
												array(
													'font'  => array(
														'size'  => 14,
														'name'  => 'Calibri'
													)
												)
											);
											
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(12);//DIAS
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);//DIAS
		
		// agregar cabeceras
		$maquinas = array();//array en la que se almacenaran los id de los procesos que aparecerán en el reporte
		$abc = 'C';
		$colm_titulos = 2;
		$i=0;
		while(!$result2->EOF)
		{
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($abc)->setWidth(13);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colm_titulos,6, $result2->fields["nombre"]);
			//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($colm_titulos)->setAutoSize(TRUE);
			
			$maquinas[$i] = $result2->fields["maquina"];//se llena la lista de IDs
			$i++;
			
			++$abc;
			$colm_titulos++;
			$result2->MoveNext();
		}
		$objPHPExcel->setActiveSheetIndex(0)->getRowDimension(6)->setRowHeight(30);
		/*
		$i='A';
		while($i!='G'){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle($i.'5')->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '808080')
													),
													'font' => array(
														'color' => array('rgb' => 'FFFFFF')
													),
													'alignment' => array(
														'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
													),
													'borders' => array(
														'allborders' => array(
															'style' => PHPExcel_Style_Border::BORDER_THIN
														)
													)
												)
											);
			++$i;
		}*/
		
		/************************/
		/*SECCION DE PREPARACION*/
		/************************/
		$lineas = array(); // array en el que se van a guardar los datos que se presentaran en el reporte
		$i=-1;               //variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$j=-1;               //variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$k=-1;               //variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$mes_actual = -1;    //variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$dia_actual = -1;    //variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$maquina_actual = -1;//variables de recorrido que permitiran guardar los datos en el lugar correcto para posteriormente presentarlos
		$meses = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'); //array de meses a 3 letras

		while (!$result1->EOF)
		{
			//convierte el dato tiempo_turno, que originalmente esta en segundos, a horas
			$horas = round(($result1->fields['tiempo_turno']/3600),2);
			
			//al dato numerico de mes que viene de la BD se le debe restar 1 (-1) para que encaje correctamente con alguno de los meses del array de arriba
			$mes = ($result1->fields['mes'])-1;
			
			//si el mes que se esta guardando es diferente al anterior entonces:
			if($mes_actual != $result1->fields['mes']){
				$mes_actual = $result1->fields['mes']; //cambie el mes
				$dia_actual = -1; //reinicie el dia
				$maquina_actual = -1; //reinicie el dato
				$i++; //prepare nuevo mes en el array
				$j=-1; //reinicie la columna del dia
				$k=-1; //reinicie la columna del dato
			}
			
			//si el dia que se esta guardando es diferente al anterior entonces:
			if($dia_actual != $result1->fields['dia']){
				$dia_actual = $result1->fields['dia']; //cambie el dia
				$maquina_actual = -1; //reinicie el dato
				$j++; //prepare el nuevo dia en el array
				$k=-1; //reinicie la columna del dato
			}
			
			//si el dato que se esta guardando es diferente al anterior entonces:
			if($maquina_actual != $result1->fields['proceso']){
				$maquina_actual = $result1->fields['proceso']; //cambie el dato
				$k++; //prepare el nuevo dato
			}
			//guarde en el mes ($i), dia ($j) y dato ($k), la fecha, la maquina y las horas trabajadas separadas por ;
			$lineas[$i][$j][$k] = $meses[$mes].'-'.$dia_actual.';'.$maquina_actual.';'.$horas;
			$result1->MoveNext();
		}
		
		$fila_dato = 7;
		for($i=0; $i<count($lineas);$i++)
		{
			//MES
			for($j=0; $j<count($lineas[$i]);$j++)
			{
				//DIA
				//echo'<tr>';
				$dia1 = "";//este dia1 es el marcador de en cual estoy parado para que no se repita en mi lista
				$columna=0;//representa la columna o dato en la lista de ids de maquinas => $maquinas = array();
				
				$columna_excel = 1;//representa la columna de EXCEL: 0=A ; 1=B ; 2=C ; etc...
				
				for($k=0; $k<count($lineas[$i][$j]);$k++)
				{
					//DATO
					$datos = $lineas[$i][$j][$k];
					list($dia2, $maquina, $horas) = explode(";", $datos);
					if($dia1 != $dia2){
						$dia1 = $dia2;
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($columna_excel,$fila_dato,$dia2);
						
						$columna_excel++; //se pasa a la siguiente columna de excel
					}
					//echo '<td>';
						if($maquinas[$columna] == $maquina)
						{
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($columna_excel,$fila_dato,$horas);
							//echo $horas;
							$columna++;
							$columna_excel++;
						}
						else{
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($columna_excel,$fila_dato,'0');
							//echo 0;
							$columna++;
							$columna_excel++;
							$k--;//se hace esto para no cambiar de linea de dato
						}
					//echo '</td>';
				}
				//echo'</tr>';
				$fila_dato++;
			}
		}
		//$abc;
		//$fila_dato
		$i='A';//la columna en la que se termina de poner el estilo
		$letras ='';
		while($i < $abc){
			$letras = $letras.$i;
			++$i;
		}
		$rest = substr($letras, -1, 1);
		$fila_dato--;//restar 1 posicion para ubicarse en la ultima fila en la que se escribio
		//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($estilodatos, "B6:".$abc.$fila_dato);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('B6:'.$rest.$fila_dato)->applyFromArray(
															array(
																'font'  => array(
																		'size'  => 12,
																		'name'  => 'Calibri'
																),
																'borders' => array(
																	'allborders' => array(
																		'style' => PHPExcel_Style_Border::BORDER_THIN
																	)
																), 
																'alignment' =>  array(
																		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
																		'rotation'   => 0,
																		'wrap'		 => TRUE
																)
															)
														);
		
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('Reporte de Horas Trabajadas');
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PEGASUS PRO LOGO');
		$objDrawing->setDescription('PEGASUS PRO LOGO');
		$objDrawing->setPath('../logo.png');
		$objDrawing->setHeight(70);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(5);
		$objDrawing->setOffsetY(10);
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Horas Diarias por Máquinas.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    }
	
}
?>
