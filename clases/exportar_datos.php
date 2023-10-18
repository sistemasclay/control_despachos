<?php

	include("adodb5/adodb-exceptions.inc.php");
	include("adodb5/adodb.inc.php");
	
class exportar_datos{
	
	function exportar_excel(){
	
		include("clases/conexion.php");
	
		require_once 'clases/PHPExcel.php';
		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Monitoreo y Control") //Autor
							 ->setLastModifiedBy("Monitoreo y Control") //Ultimo usuario que lo modificó
							 ->setTitle("Planilla de Parametrización Pegasus Pro")
							 ->setSubject("Planilla de Parametrización Pegasus Pro")
							 ->setDescription("Planilla de Parametrización Pegasus Pro")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("backup excel");
							 
							 
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' 		=>14,
	            'color'     => array(
    	            	'rgb' => 'FFFFFF'
        	       	)
            ),
			'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => '000000')
			)
        );		
		
		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
				'size' 		=>10,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
/*			'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
        		'startcolor' => array(
            		'rgb' => 'c47cf2'
        		),
        		'endcolor'   => array(
            		'argb' => 'FF431a5d'
        		)
			),
*/			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => '969696')
			),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));
		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
					'name'      => 'Arial',               
					'color'     => array(
						'rgb' => '000000'
					)
				),
			));
			
		//							//
		//		HOJA DE USUARIOS	//
		//							//
		
		$sql = "SELECT 	id_persona, 
						nombre_persona,  
						nivel
				FROM personal
				ORDER BY id_persona";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar los usuarios: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		
		$tituloReporte = "DATOS DE USUARIOS";
		$titulosColumnas = array('Id Usuario', 'Nombre', 'Contraseña', 'Nivel');
		
		$objPHPExcel->setActiveSheetIndex(0)
					->mergeCells('A1:C1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
        		    ->setCellValue('D2',  $titulosColumnas[3]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $result->fields['id_persona']." ")
		            ->setCellValue('B'.$i,  $result->fields['nombre_persona'])
        		    ->setCellValue('C'.$i,  '')
        		    ->setCellValue('D'.$i,  $result->fields['nivel']);
					$i++;
					$result->MoveNext();
		}					

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:D".($i-1));
		
		for($i = 'A'; $i <= 'D'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja

		$objPHPExcel->getActiveSheet()->setTitle('Usuarios');
		
		//							//
		//		HOJA DE PROCESOS	//
		//							//
		
		$objPHPExcel->createSheet(1);
		
		$sql = "SELECT 	id_proceso, 
						nombre, 
						descripcion
				FROM procesos
				ORDER BY id_proceso";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar los procesos: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		
		$tituloReporte = "DATOS DE PROCESOS";
		$titulosColumnas = array('Id Proceso', 'Nombre', 'Descripción');
		
		$objPHPExcel->setActiveSheetIndex(1)
					->mergeCells('A1:C1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(1)
        		    ->setCellValue('A'.$i,  $result->fields['id_proceso']." ")
		            ->setCellValue('B'.$i,  $result->fields['nombre'])
        		    ->setCellValue('C'.$i,  $result->fields['descripcion']);
					$i++;
					$result->MoveNext();
		}					

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:C".($i-1));
		
		for($i = 'A'; $i <= 'C'; $i++){
			$objPHPExcel->setActiveSheetIndex(1)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Procesos');

		//						//
		//	HOJA DE PRODUCTOS	//
		//						//
			
		$objPHPExcel->createSheet(2);
			
		$sql = "SELECT 	id_producto, 
						nombre_producto, 
						descripcion
				FROM productos
				ORDER BY id_producto";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
			
		$tituloReporte = "DATOS DE PRODUCTOS";
		$titulosColumnas = array('Id Producto', 'Nombre', 'Descripción');
		
		$objPHPExcel->setActiveSheetIndex(2)
					->mergeCells('A1:C1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(2)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(2)
        		    ->setCellValue('A'.$i,  $result->fields['id_producto']." ")
		            ->setCellValue('B'.$i,  $result->fields['nombre_producto'])
        		    ->setCellValue('C'.$i,  $result->fields['descripcion']." ");
					$i++;
					$result->MoveNext();
		}					

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:C".($i-1));
		
		for($i = 'A'; $i <= 'C'; $i++){
			$objPHPExcel->setActiveSheetIndex(2)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Productos');

		//						//
		//	HOJA DE PARAMETROS	//
		//						//
				
		$objPHPExcel->createSheet(3);
				
		$sql = "SELECT	id_parametro, 
						nombre_parametro, 
						descripcion_parametro, 
						unidades_material
				FROM cal_parametros 
				order by id_parametro";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
			
		$tituloReporte = "DATOS DE PARAMETROS";
		$titulosColumnas = array('Id Parametro', 'Nombre', 'Descripción', 'Unidad Medida');
		
		$objPHPExcel->setActiveSheetIndex(3)
					->mergeCells('A1:D1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(3)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
        		    ->setCellValue('D2',  $titulosColumnas[3]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(3)
        		    ->setCellValue('A'.$i,  $result->fields['id_parametro']." ")
		            ->setCellValue('B'.$i,  $result->fields['nombre_parametro'])
        		    ->setCellValue('C'.$i,  $result->fields['descripcion_parametro'])
        		    ->setCellValue('D'.$i,  $result->fields['unidad_medida']);
					$i++;
					$result->MoveNext();
		}					

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:D".($i-1));
		
		for($i = 'A'; $i <= 'D'; $i++){
			$objPHPExcel->setActiveSheetIndex(3)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Parametros');

		//					//
		//	HOJA DE FALLOS	//
		//					//
		
		$objPHPExcel->createSheet(4);
				
		$sql = "SELECT	id_fallo,
						nombre_fallo,
						descripcion_fallo
				FROM cal_fallos
				ORDER BY id_fallo ";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
			
		$tituloReporte = "DATOS DE FALLOS";
		
		
		$titulosColumnas = array('Id Fallo', 'Nombre', 'Descripción');
		
		$objPHPExcel->setActiveSheetIndex(4)
					->mergeCells('A1:C1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(4)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(4)
        		    ->setCellValue('A'.$i,  $result->fields['id_producto']." ")
		            ->setCellValue('B'.$i,  $result->fields['nombre_producto'])
        		    ->setCellValue('C'.$i,  $result->fields['descripcion']);
					$i++;
					$result->MoveNext();
		}

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:C".($i-1));
		
		for($i = 'A'; $i <= 'C'; $i++){
			$objPHPExcel->setActiveSheetIndex(4)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Fallos');

		//							//
		//	HOJA DE ESTANDARES PROD	//
		//							//
				
		$objPHPExcel->createSheet(5);
				
		$sql = "SELECT	id_producto,
						id_parametro,
						minimo,
						maximo
		FROM cal_estandar_producto
		ORDER BY id_estandar_producto";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
				
		$tituloReporte = "DATOS EST. PRODUCTO";
		$titulosColumnas = array('Id Producto', 'Id Parametro', 'Minimo', 'Maximo');
		
		$objPHPExcel->setActiveSheetIndex(5)
					->mergeCells('A1:D1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(5)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
        		    ->setCellValue('D2',  $titulosColumnas[3]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(5)
        		    ->setCellValue('A'.$i,  $result->fields['id_producto']." ")
		            ->setCellValue('B'.$i,  $result->fields['id_parametro']." ")
        		    ->setCellValue('C'.$i,  $result->fields['minimo']." ")
        		    ->setCellValue('D'.$i,  $result->fields['maximo']);
					$i++;
					$result->MoveNext();
		}					

		$result->Close();		

		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:D".($i-1));
		
		for($i = 'A'; $i <= 'D'; $i++){
			$objPHPExcel->setActiveSheetIndex(5)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Est. Producto');

		//						//
		//	HOJA DE EST. FALLOS	//
		//						//
		
		$objPHPExcel->createSheet(6);
		
		$sql = "SELECT	id_producto,
						id_parametro,
						id_fallo,
						tipo_desfase
				FROM cal_estandar_fallos 
				ORDER BY id_estandar_fallo";
		
		$result=$conexion_pg->Execute($sql);
		
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
			
		$tituloReporte = "DATOS EST. FALLOS";
		
		
		$titulosColumnas = array('Id Producto', 'Id Parametro', 'Id Fallo', 'Tipo Desfase');
		
		$objPHPExcel->setActiveSheetIndex(6)
					->mergeCells('A1:E1');
					
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(6)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
        		    ->setCellValue('D2',  $titulosColumnas[3]);

					
		$i = 3;
		while (!$result->EOF) {
			$objPHPExcel->setActiveSheetIndex(6)
        		    ->setCellValue('A'.$i,  $result->fields['id_producto']." ")
		            ->setCellValue('B'.$i,  $result->fields['id_parametro'])
        		    ->setCellValue('C'.$i,  $result->fields['id_fallo'])
        		    ->setCellValue('D'.$i,  $result->fields['tipo_desfase']);
					$i++;
					$result->MoveNext();
		}					

		$result->Close();
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:D".($i-1));
		
		for($i = 'A'; $i <= 'D'; $i++){
			$objPHPExcel->setActiveSheetIndex(6)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Est. Fallos');	
		
		
	$conexion_pg->Close();
	
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Planilla de Parametrización Pegasus Pro.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}
?>