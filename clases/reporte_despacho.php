<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('memory_limit','1024M');
include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");
require('fpdf.php');


class reportes {
	
	function detalle_producto_id($codigo)
    {
        include("conexion.php");
        $sql="SELECT * FROM productos WHERE id_producto = '$codigo'";
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
            {
            echo 'error al Buscar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }
	
	function pdf_despacho($lista_productos)
	{
		
		//INICIO
		$pdf=new FPDF('P','mm','Letter');		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->Ln(10);
		
		$pdf->Cell(40,8,'SE DEBEN PREPARAR LOS SIGUIENTES PRODUCTOS:');
		$pdf->Ln();
		$pdf->Ln();
		$cant_prod = count($lista_productos["id_producto"]);
		for($i=0;$i<$cant_prod;$i++) {
			
			$producto = $this->detalle_producto_id($lista_productos["id_producto"][$i]);
			
			$pdf->Cell(20,8,$lista_productos["id_producto"][$i],1);			
			$pdf->Cell(150,8,$producto->fields['nombre_producto'],1);			
			$pdf->Cell(20,8,' '.$lista_productos["cantidad_p"][$i],1,1,'c');
			$pdf->Ln();
		}
		$pdf->Output();
	}
}
?>
