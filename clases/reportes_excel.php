<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
ini_set('memory_limit','1024M');
ini_set('max_execution_time','180');
include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_plotline.php');
require_once ('jpgraph/jpgraph_scatter.php');
require('fpdf.php');

class reportes_excel {
    //put your code here

	function calcular_desviacion($lista_datos){
		$promedio = 0;
		$i=0;
		foreach ($lista_datos as $valor) {
			$promedio = $promedio + $valor;
			$i++;
		}
		$promedio = $promedio/$i;
		$varianza = 0;
		foreach ($lista_datos as $valor) {
			$varianza = $varianza + (pow($valor-$promedio,2));
		}
		$varianza = $varianza/$i;
		$varianza = sqrt($varianza);
		
		return $varianza;
	}
	
	function listar_defectos()
	{
		include("conexion.php");
		$sql = "SELECT 	id_fallo, 
						trim(nombre_fallo) nombre_fallo
				FROM cal_fallos ORDER BY id_fallo";
		try{
			$result=$conexion_pg->Execute($sql);
			if ($result === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
			$conexion_pg->Close();
			$i=0;
			$ar;
			while (!$result->EOF)
			{
				$ar[$i]["id_fallo"]=$result->fields["id_fallo"];
				$ar[$i]["nombre_fallo"]=$result->fields["nombre_fallo"];
				$result->MoveNext();
				$i++;
			}
			return $ar;
		}
		catch (Exception $e){
			$actual = "Error al listar: ".$e->getMessage()."\n";
			echo $actual;
			$conexion_pg->Close();
		}
	}
	
	function detalle_producto($codigo)
    {
		include("conexion.php");
		$sql="SELECT * FROM productos WHERE id_producto = '$codigo'";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al Buscar: '.$conn->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
    }
	
	/***********
	*	Genera la grafica de rangos dado los siguientes datos
	*	$parametro: Nombre del parametro al que pertenece la grafica
	*	$lie: Representa el Limite Inferior de Especificación //barra ROJA 1
	*	$lic: Representa el Limite Inferior de Control //barra NEGRA 1
	*	$lsc: Representa el Limite Superior de Control //barra NEGRA 2
	*	$lse: Representa el Limite Superior de Especificación //barra ROJA 2
	*	$valores: Representa los valores de la linea
	*	$turnos: Representa las etiquetas del eje X
	***********/
	
	function grafica_rangos($parametro, $lie, $lic, $lsc, $lse, $valores, $turnos, $numero)
	{
		$datay1 = $valores;
		
		// Setup the graph
		$graph = new Graph(450,500);
		$graph->img->SetMargin(0,0,50,50);
		$graph->SetScale("textlin");
		$graph->SetAngle(90);
		$graph->SetShadow();
		$graph->SetFrame(true,'black',0);
		
		//$graph->title->Set($parametro);
		$graph->title->SetFont(FF_ARIAL,FS_BOLD,15);
		
		$graph->ygrid->SetFill(false);
		$graph->yaxis->HideLine(true);
		$graph->yaxis->HideTicks(true);
		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,10);
		$graph->yaxis->SetTickSide(SIDE_DOWN);
		$graph->yaxis->SetLabelAngle(90);
		$graph->xaxis->SetTickLabels($turnos);
	
		//$graph->xaxis->scale->SetGrace(50);
		// Create the plot
		if($lie != 0){
			$l1 = new PlotLine(HORIZONTAL,$lie,"red",2);
			$graph->AddLine($l1);
			$graph->yaxis->scale->SetAutoMin($lie-1);
		}
		else{
			$graph->yaxis->scale->SetAutoMin($lic-1);
		}
		
		$l2 = new PlotLine(HORIZONTAL,$lic,"darkgreen",1);
		$graph->AddLine($l2);
		
		$l3 = new PlotLine(HORIZONTAL,$lsc,"darkgreen",1);
		$graph->AddLine($l3);
		
		if($lse != 0 && $lse > $lsc){
			$l4 = new PlotLine(HORIZONTAL,$lse,"red",2);
			$graph->AddLine($l4);
			$graph->yaxis->scale->SetAutoMax($lse+1);
		}
		else{
			$graph->yaxis->scale->SetAutoMax($lsc+1);
		}
		
		$p1 = new LinePlot($datay1);
		$graph->Add($p1);
		
		// Use an image of favourite car as marker
		//$p1->mark->SetType(MARK_IMG,'new1.gif',0.8);
		$p1->SetColor('#aadddd');
		$p1->value->SetFormat('%g');//"%d"para enteros --- "%g"para decimales
		//$p1->value->Show();
		$p1->value->SetColor('#55bbdd');
		//$p1->value->SetMargin(10);
		$p1->value->SetAngle(90);
		
		$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
		$p1->mark->SetColor('#55bbdd');
		$p1->mark->SetFillColor('#55bbdd');
		
		
		if (file_exists('grafica x-r'.$numero.'.png'))
		{
			unlink('grafica x-r'.$numero.'.png');
		}
		// Finally stroke the graph
		$graph->Stroke('grafica x-r'.$numero.'.png');
	}
	
	function grafica_ocurrencias($conteos,$nombres)
	{
		// Some data
		$datay=array(1,1,300);
		
		// Create the graph and setup the basic parameters
		$graph = new Graph(800,500,'auto');
		$graph->img->SetMargin(100,30,30,200);
		$graph->SetScale("textint");
		$graph->SetShadow();
		$graph->SetFrame(false); // No border around the graph
		// Add some grace to the top so that the scale doesn't
		// end exactly at the max value.
		
		$graph->yaxis->scale->SetGrace(20);
		//$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD,10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,10);
		$graph->yaxis->SetLabelMargin(3); 
		
		// Setup X-axis labels
		$graph->xaxis->SetTickLabels($nombres);
		$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,6);
		$graph->xaxis->SetLabelAngle(90);
		//$graph->xaxis->SetLabelMargin(3); 
		
		// Setup graph title ands fonts
		
		//$graph->title->Set("DEFECTOS VS OCURRENCIAS");
		$graph->title->SetFont(FF_ARIAL,FS_NORMAL,24);
		$graph->yaxis->title->Set("OCURRENCIAS");
		$graph->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,12);
		$graph->yaxis->title->SetMargin(15);
		
		// Create a bar pot
		$bplot = new BarPlot($conteos);
		$bplot->SetFillColor('#FF0000');
		$bplot->SetWidth(0.5);
		
		// Setup the values that are displayed on top of each bar
		$bplot->value->Show();
		$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,6);
		$bplot->value->SetAngle(90);
		
		// Black color for positive values and darkred for negative values
		$bplot->value->SetColor("black","darkred");
		$graph->Add($bplot);
		
		if (file_exists('ocurrencias.png'))
		{
		unlink('ocurrencias.png');
		}
		// Finally stroke the graph
		$graph->Stroke('ocurrencias.png');
	
	}
	
	//+-----------------------------------------------------+
	//|                                                     |
	//+-----------------------------------------------------+
	
	function pdf_grafico_rangos($sql_datos,$fechai,$fechaf)
	{
		// echo $sql;
		include("conexion.php");
		try{
			$resultDatos=$conexion_pg->Execute($sql_datos);
			if ($resultDatos === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
		}
		catch (Exception $e){
			$fichero = 'log_errores.txt';
			// Abre el fichero para obtener el contenido existente
			$actual = file_get_contents($fichero);
			// Añade una nueva persona al fichero
			$actual .= "FECHA: ".$fechaactual.". Error al listar: ".$e->getMessage()."\n";
			// Escribe el contenido al fichero
			file_put_contents($fichero, $actual);
			$conexion_pg->Close();
		}
		
		$producto = $resultDatos->fields["nombre_producto"];
		
			//ob_end_clean();
			$pdf=new FPDF('L','mm','Letter');
			//$pdf->AddPage();
			$pdf->SetFillColor(0, 0, 0);
			$pdf->AddPage();
			$pdf->Image('imgs/logo3.jpg',10,20,60);
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(260,-1,'',0,0,'C',true);
		$pdf->Ln();
			$pdf->Cell(80,10);
		$pdf->Ln();
			$pdf->Cell(80,10);
			$pdf->Cell(40,10,'Graficos XR',0,0,'C');
			//  $pdf->Ln();
			$pdf->Cell(10);
			$pdf->Cell(40,10,$producto,0,0,'J');
		$pdf->Ln();
			$pdf->Cell(84);
			$pdf->Cell(40,20,'Entre las fechas: '.$fechai.' y '.$fechaf);
		$pdf->Ln();
			$datos=array();
			$i=0;
			$j=-1;
			$parametro_actual = "";
			while(!$resultDatos->EOF){
				if($parametro_actual != $resultDatos->fields["id_parametro"]){
					$j++;
					$i=0;
					$parametro_actual = $resultDatos->fields["id_parametro"];
					$datos[$j]["parametro"] = $resultDatos->fields["nombre_parametro"];
					$datos[$j]["lie"] = $resultDatos->fields["limite_inf_espec"];
					$datos[$j]["lic"] = $resultDatos->fields["limite_inf_control"];
					$datos[$j]["lsc"] = $resultDatos->fields["limite_sup_control"];
					$datos[$j]["lse"] = $resultDatos->fields["limite_sup_espec"];
				}
				$datos[$j]["valores"][$i] = $resultDatos->fields["medida"];
				$datos[$j]["turnos"][$i] = $resultDatos->fields["id_registro"];
				
				$resultDatos->MoveNext();
				$i++;
			}
			$datos_lenght = count($datos);
			$j = 0;
			$i = 0;
			while($j < $datos_lenght){
				$this->grafica_rangos($datos[$j]["parametro"], $datos[$j]["lie"], $datos[$j]["lic"], $datos[$j]["lsc"], $datos[$j]["lse"], $datos[$j]["valores"], $datos[$j]["turnos"], $j);
				$pdf->Cell(120,10,$datos[$j]["parametro"],0,0,'C');
				$pdf->Cell(10);
				$pdf->Image('grafica x-r'.$j.'.png',(10+($i*140)),60,120,150);
				$j++;
				$i++;
				if($j < $datos_lenght){
					$pdf->Cell(10);
					if(($i%2)==0){
						$i=0;
						$pdf->AddPage();
						$pdf->Image('imgs/logo3.jpg',10,20,60);
						$pdf->SetFont('Arial','B',16);
						$pdf->Cell(260,-1,'',0,0,'C',true);
					$pdf->Ln();
						$pdf->Cell(80,10);
					$pdf->Ln();
						$pdf->Cell(80,10);
						$pdf->Cell(40,10,'Graficos XR',0,0,'C');
						//  $pdf->Ln();
						$pdf->Cell(10);
						$pdf->Cell(40,10,$producto,0,0,'J');
					$pdf->Ln();
						$pdf->Cell(84);
						$pdf->Cell(40,20,'Entre las fechas: '.$fechai.' y '.$fechaf);
					$pdf->Ln();
					}
				}
			}
			$pdf->Output();
	}
	
	function pdf_grafico_ocurrencias($sql, $id_producto, $fechai, $fechaf)
	{
		$codigos=array();
		$totales=array();
		$defectos=$this->listar_defectos();
		$cantidad_defectos = count($defectos);
		//echo $cantidad_defectos;
		$i=0;
		$totales_p=0;
		$j=0;
		for($i=0;$i<$cantidad_defectos;$i++)
		{
			include("conexion.php");
			$sqlf=$sql." "."AND id_fallo='".$defectos[$i]["id_fallo"]."'";
			$result=$conexion_pg->Execute($sqlf);
			if ($result === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
			$cantidad_contada=0;
			while (!$result->EOF) {
				$cantidad_contada=$cantidad_contada+1;
				$result->MoveNext();
			}
			if($cantidad_contada>=1)
			{
				$codigos[]=$defectos[$i]["id_fallo"];
				$nombres[]=trim($defectos[$i]["nombre_fallo"]);
				$totales[]=$cantidad_contada;
				$totales_p++;
				$j++;
			}
				$conexion_pg->Close();
			if($j==30){
				break;
			}
		}
		$iterator=0;
		for ($i=0;$i<=$totales_p-1;$i++)
		{
			for ($j=$i+1;$j<$totales_p;$j++)
			{
				if ($totales[$i]<$totales[$j])
				{
					$auxt=$totales[$i];
					$auxc=$codigos[$i];
					$auxn=$nombres[$i];
					
					$totales[$i]=$totales[$j];
					$codigos[$i]=$codigos[$j];
					$nombres[$i]=$nombres[$j];
		
		
					$totales[$j]=$auxt;
					$codigos[$j]=$auxc;
					$nombres[$j]=$auxn;
				}
			}
		}
	
		$pdf=new FPDF('L','mm','Letter');
		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->AddPage();
		$pdf->Image('imgs/logo3.jpg',10,8,50);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(80);
		$pdf->Cell(70,8,'Grafico de Ocurrencias Defectos',0,0,'C',true);
	
		$pdf->Cell(10);
		$producto = $this->detalle_producto($id_producto);
		$pdf->Cell(40,8,$producto->fields['nombre_producto'],0,0,'L',true);
		$this->grafica_ocurrencias($totales, $nombres);
		$pdf->Image('ocurrencias.png',10,30,250,150);
		$pdf->AddPage();
		$pdf->Ln();
		$pdf->Ln();
		for($i=0;$i<$totales_p;$i++)
		{
			$pdf->Cell(40);
			$pdf->Cell(40,8,$codigos[$i]." - ".$nombres[$i],0,0,'L',true);
			$pdf->Ln();
		}
		
		$pdf->Output();
	}

    function excel_bitacora($sql_datos, $sql_parametros, $sql_defectos, $fecha_inicio, $fecha_final)
    {
		$resultDatos;
		$resultParametros;
		$resultDefectos;
		$fechaactual= date("Y-m-d H:i:s");
		
		include("conexion.php");
		try{
			$resultDatos=$conexion_pg->Execute($sql_datos);
			if ($resultDatos === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
		}
		catch (Exception $e){
			$fichero = 'log_errores.txt';
			$actual = file_get_contents($fichero);
			$actual .= "FECHA: ".$fechaactual.". Error al leer los turnos: ".$e->getMessage()."\n";
			file_put_contents($fichero, $actual);
			$conexion_pg->Close();
		}
		try{
			$resultParametros=$conexion_pg->Execute($sql_parametros);
			if ($resultParametros === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
		}
		catch (Exception $e){
			$fichero = 'log_errores.txt';
			$actual = file_get_contents($fichero);
			$actual .= "FECHA: ".$fechaactual.". Error al leer los parametros: ".$e->getMessage()."\n";
			file_put_contents($fichero, $actual);
			$conexion_pg->Close();
		}
		try{
			$resultDefectos=$conexion_pg->Execute($sql_defectos);
			if ($resultDefectos === false)
			{
				echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
			}
		}
		catch (Exception $e){
			$fichero = 'log_errores.txt';
			$actual = file_get_contents($fichero);
			$actual .= "FECHA: ".$fechaactual.". Error al leer los fallos: ".$e->getMessage()."\n";
			file_put_contents($fichero, $actual);
			$conexion_pg->Close();
		}
		$conexion_pg->Close();
		
		/** Error reporting */
		error_reporting(E_ALL);
		
		/** PHPExcel */
		require_once 'clases/PHPExcel.php';
		
		/** PHPExcel_IOFactory */
		require_once 'clases/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control")
									->setLastModifiedBy("Monitoreo y Control")
									->setTitle("Bitacora de Batch")
									->setSubject("Bitacora de Batch")
									->setDescription("Bitacora Batchs Pegasus PRO")
									->setKeywords("office 2007 openxml php")
									->setCategory("Informe");
		
		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'BITACORA DE REGISTROS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,2, 'Desde');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,2, $fecha_inicio);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,2, 'Hasta');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,2, $fecha_final);

		// agregar cabeceras
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,5, 'PROCESO / PROVEEDOR')
					->setCellValueByColumnAndRow(1,5, 'LOTE')
					->setCellValueByColumnAndRow(2,5, 'ORDEN PRODUCCIÓN')
					->setCellValueByColumnAndRow(3,5, 'PRODUCTO')
					->setCellValueByColumnAndRow(4,5, 'REGISTRO')
					->setCellValueByColumnAndRow(5,5, 'FECHA')
					->setCellValueByColumnAndRow(6,5, 'TURNO')
					->setCellValueByColumnAndRow(7,5, 'ENCARGADO');
					
		//organizar ancho para las anteriores columnas
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(18);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(20);
		
		$j='I';
		$i=8;
		$cant_param = 0;
		while(!$resultParametros->EOF){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($i,5, $resultParametros->fields["nombre_parametro"]);
					
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
			$i++;
			++$j;
			$cant_param++;
			$resultParametros->MoveNext();
		}
		$pos_defect = 0;
		$lista_defectos;
		while(!$resultDefectos->EOF){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($i,5, $resultDefectos->fields["nombre_fallo"]);
					
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
			
			$lista_defectos[$i] = $resultDefectos->fields["id_fallo"];
			$i++;
			++$j;
			$pos_defect++;
			$resultDefectos->MoveNext();
		}
		//esta variable se utilizara en el futuro para añadir los bordes a las  celdas, su valor actual es la ultima columna en la que se escribió información
		$ultima_columna = $j;
		$i=5;
		$col_param = 0;
		$registro_anterior = 0;
		$parametro_anterior = 0;
		$fila_actual = 0;
		
		$lista_param_desviacion;
		$index_param_desviacion = 0;
		while (!$resultDatos->EOF)
		{
			$registro = $resultDatos->fields['id_registro'];
			$parametro = $resultDatos->fields['id_parametro'];
			if($registro_anterior!=$registro){
				$i++;
				$col_param=8;
				$j = $col_param + $cant_param;
				if($resultDatos->fields['id_proceso']){
					$proc_prov = $resultDatos->fields['nombre_proceso'];
				}
				else{
					$proc_prov = $resultDatos->fields['nombre_proveedor'];
				}
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$i,$proc_prov)
							->setCellValueByColumnAndRow(1,$i,$resultDatos->fields['lote'])
							->setCellValueByColumnAndRow(2,$i,$resultDatos->fields['orden'])
							->setCellValueByColumnAndRow(3,$i,$resultDatos->fields['nombre_producto'])
							->setCellValueByColumnAndRow(4,$i,$registro)
							->setCellValueByColumnAndRow(5,$i,$resultDatos->fields['ts_registro'])
							->setCellValueByColumnAndRow(6,$i,$resultDatos->fields['id_t_muestreo'])
							->setCellValueByColumnAndRow(7,$i,$resultDatos->fields['nombre_persona'])
							->setCellValueByColumnAndRow($col_param,$i,$resultDatos->fields['medida'])
							;
				if($resultDatos->fields['id_fallo']){
					$columna_defecto = array_search($resultDatos->fields['id_fallo'], $lista_defectos);
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow($columna_defecto,$i,1)
							;
				}
				$lista_param_desviacion[$parametro][$index_param_desviacion] = $resultDatos->fields['medida'];
				$index_param_desviacion++;
				$registro_anterior = $registro;
				$parametro_anterior = $parametro;
				$col_param++;
			}
			else{
				if($parametro_anterior!=$parametro){
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($col_param,$i,$resultDatos->fields['medida'])
								;
					if($resultDatos->fields['id_fallo']){
						$columna_defecto = array_search($resultDatos->fields['id_fallo'], $lista_defectos);
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($columna_defecto,$i,1)
								;
					}
					$lista_param_desviacion[$parametro][$index_param_desviacion] = $resultDatos->fields['medida'];
					$index_param_desviacion++;
					$col_param++;
					$parametro_anterior = $parametro;
				}
				else{
					
					if($resultDatos->fields['id_fallo']){
						$columna_defecto = array_search($resultDatos->fields['id_fallo'], $lista_defectos);
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow($columna_defecto,$i,1)
								;
					}
				}
			}
			$fila_actual = $i;
			$resultDatos->MoveNext();
		}
		//aplica todos los bordes a las celdas con información
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A5:'.$ultima_columna.$fila_actual)->applyFromArray(
															array(
																	'borders' => array(
																		'allborders' => array(
																			'style' => PHPExcel_Style_Border::BORDER_THIN
																		)
																	),
																	'alignment' => array(
																		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
																	)
																)
															);
		//la fila actual pasa a ser la siguiente a la ultima fila con datos
		$fila_actual++;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(7,$fila_actual, 'DESV. STD.');
		
		//en esta sección se guardan los datos de la variaciones
		$variaciones;
		$i=0;
		foreach($lista_param_desviacion as $lista){
			$variaciones[$i] = $this->calcular_desviacion($lista);
			$i++;
		}
		//y en esta sección se escriben en el documento
		$j='H';
		$i=8;
		foreach($variaciones as $number){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($i,$fila_actual, $number);
			$i++;
			++$j;
		}
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('H'.$fila_actual.':'.$j.$fila_actual)->applyFromArray(
												array(
													'fill' => array(
														'type' => PHPExcel_Style_Fill::FILL_SOLID,
														'color' => array('rgb' => '8DB4E3')
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
		
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('Bitacora de Batchs');
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PEGASUSPRO logo');
		$objDrawing->setDescription('PEGASUSPRO logo');
		$objDrawing->setPath('imgs/logo3.png');
		$objDrawing->setHeight(80);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(2);
		$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Bitacora de Registros de Calidad.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    }

}
?>
