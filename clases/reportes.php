<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 ini_set('memory_limit','512M');
include("adodb5/adodb-exceptions.inc.php");
include("adodb5/adodb.inc.php");
 require('fpdf.php');
class reportes {


    function listar_paradas()
    {
        include("conexion.php");
        $sql =	"SELECT * FROM paradas where estado_parada=1";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }
    
        function listar_productos()
    {
        include("conexion.php");
        $sql =	"SELECT * FROM productos where estado=1";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

    
    function listar_turnos_op($op)
    {
        include("conexion.php");
        $sql =	"SELECT t.fecha_inicio,t.fecha_fin,t.id_turno,t.unidades_conteo,p.nombre FROM turnos as t,procesos as p WHERE p.id_proceso=t.id_proceso AND orden_produccion= '$op'";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;

    }

	function listar_recetas($producto)
    {
        include("conexion.php");
        $sql =	"SELECT * FROM recetas as b INNER JOIN materiales as a ON (b.id_material= a.id_material) WHERE id_producto='$producto'";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

       function detalle_op($codigo)
    {
        include("conexion.php");
        $sql="SELECT * FROM ordenes_produccion as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) INNER JOIN productos as c ON (b.id_producto= c.id_producto) WHERE id_orden_produccion= '$codigo'";
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
            {
            echo 'error al Buscar: '.$conn->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }


    function listar_ops()
    {
        include("conexion.php");
       // $sql =	"SELECT * FROM ordenes_produccion";
       $sql = "SELECT * FROM ordenes_produccion as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) INNER JOIN productos as c ON (b.id_producto= c.id_producto) order by id_orden_produccion DESC";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }
	
	function listar_personal()
    {
        include("conexion.php");
        $sql =	"SELECT * FROM personal WHERE estado_persona = 1 AND nivel = 1 ORDER BY id_persona";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

	function listar_procesos()
    {
        include("conexion.php");
        $sql =	"SELECT * FROM procesos WHERE estado=1";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }
	
	function listar_procesos_activos()
    {
        include("conexion.php");
        $sql =	"SELECT * FROM procesos WHERE estado=1";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

            function detalle_proceso($codigo)
    {
        include("conexion.php");
        $sql="SELECT * FROM procesos WHERE id_proceso = '$codigo'";
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
            {
            echo 'error al Buscar: '.$conn->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

	function detalle_producto_proceso($proceso, $producto)
    {
        include("conexion.php");
        $sql="SELECT * FROM producto_proceso WHERE id_proceso = '$proceso' AND id_producto = '$producto'";
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
            {
            echo 'error al Buscar: '.$conn->ErrorMsg().'<BR>';
            }
         $conexion_pg->Close();
         return $result;
    }

	function listar_turnos_maquina($id_maquina)
    {
        include("conexion.php");
        $sql =	"SELECT id_turno FROM turnos WHERE id_proceso = '$id_maquina' ORDER BY id_turno DESC";
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
       // $sql =	"SELECT * FROM ordenes_produccion";
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
  FROM turno_asistencia as a INNER JOIN personal as b ON (a.id_empleado= b.id_persona)
  WHERE id_turno='".$id_turno."' AND id_proceso='".$id_proceso."'";
       $result=$conexion_pg->Execute($sql);
	if ($result === false)
            {
            echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
            }
            $conexion_pg->Close();
         return $result;
    }

    function listar_turno_paradas($id_turno,$id_proceso)
    {
        include("conexion.php");
       // $sql =	"SELECT * FROM ordenes_produccion";
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

 function tiempo_segundos($segundos){
    $minutos=$segundos/60;
    $horas=floor($minutos/60);
    $minutos2=$minutos%60;
    $segundos_2=$segundos%60%60%60;
    if($minutos2<10)$minutos2='0'.$minutos2;
    if($segundos_2<10)$segundos_2='0'.$segundos_2;

    if($segundos<60){ /* segundos */
    $resultado= '00:00:'.round($segundos);
   /*    if($segundos<10)
       {$resultado=$resultado.'0';} */
    }elseif($segundos>60 && $segundos<3600){/* minutos */
    $resultado= '00:'.$minutos2.':'.$segundos_2;
    }else{/* horas */
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

    function pdf_bitacora($sql,$id_proceso)
    {
        $etiquetas=$this->listar_etiquetas();
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        //ob_end_clean();

    $pdf=new FPDF('P','mm','Letter');

     while (!$result->EOF) {

	 
	$producto_proceso=$this->detalle_producto_proceso($result->fields["id_proceso"], $result->fields["id_producto"]);
	$estandar=$producto_proceso->fields["var1"];
	$unidades_pulso=$producto_proceso->fields["unidades_pulso"];
	 
	 
    $pdf->AddPage();
    $pdf->Image('logo2.jpg',10,8,33);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Bitacora de Batch ');
    $pdf->Ln();
    $pdf->Cell(80);
    //$pdf->SetFont('Arial','I',16);
    $pdf->Cell(40,8,$result->fields['nombre']);
$pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,8,'Batch Numero: ');
    $pdf->Cell(2);
    $pdf->SetFont('Arial','I',16);
    $pdf->Cell(10,8,$result->fields['id_turno']);
     $pdf->Cell(10);
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(8,8,'Producto: ');
     $pdf->Cell(20);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(10,8,$result->fields['id_producto']);
     $pdf->Cell(20);
     $pdf->Cell(40,8,$result->fields['nombre_producto']);

     $pdf->Line(10, 34, 205, 34);
     $pdf->Ln();
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(20,8,$etiquetas[8]['etiqueta'].':');
     $pdf->Cell(30);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(40,8,$result->fields['dato_extra']);
     $pdf->Cell(5);
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(10,8,'Orden: ');
     $pdf->Cell(10);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(20,8,$result->fields['orden_produccion']);
     $pdf->Ln();
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(20,8,'Fecha Inicio: ');
     $pdf->Cell(15);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(60,8,$result->fields['fecha_inicio']);
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(20,8,'Fecha Final: ');
     $pdf->Cell(15);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(60,8,$result->fields['fecha_fin']);

     $pdf->Ln();
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(20,8,'Unidades: ');
     $pdf->Cell(15);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(60,8,number_format($result->fields['unidades_conteo'], 0, '', '.'));
      $pdf->SetFont('Arial','B',16);
     $pdf->Cell(20,8,'Produccion Final: ');
     $pdf->Cell(30);
     $pdf->SetFont('Arial','I',16);
     $pdf->Cell(60,8,number_format($result->fields['produccion_final'], 0, '', '.'));
     
     $pdf->Ln();
     $pdf->SetTextColor(255, 255, 255);
     $pdf->SetFillColor(100, 100, 100);

     $pdf->Cell(70,8,'Tiempos ',1,0,'C',true);
     $pdf->Cell(1);
    $pdf->Cell(62,8,'Indicadores ',1,0,'C',true);
    $pdf->Cell(1);
    $pdf->Cell(62,8,'Perdidas ',1,0,'C',true);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Tiempo Total Parada');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_total_paro']));
     $pdf->Cell(40,8,$etiquetas[0]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_1']);
    $pdf->Cell(40,8,$etiquetas[12]['etiqueta']);
    $pdf->Cell(23,8,$result->fields['desperdicio_1']);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Tiempo Parada Prog');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_paro_prog']));
     $pdf->Cell(40,8,$etiquetas[1]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_2']);
    $pdf->Cell(40,8,$etiquetas[13]['etiqueta']);
    $pdf->Cell(23,8,$result->fields['desperdicio_2']);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'T. Paradas NO Prog');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_paro_no_p']));
     $pdf->Cell(40,8,$etiquetas[2]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_3']);
    $pdf->Cell(40,8,$etiquetas[14]['etiqueta']);
    $pdf->Cell(23,8,$result->fields['desperdicio_3']);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Parada Averias');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_paro_g1']));
     $pdf->Cell(40,8,$etiquetas[3]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_4']);
    $pdf->Cell(40,8,'Total Desperdicio');
    $total_desp = 0;
    $total_desp=$result->fields['desperdicio_1']+$result->fields['desperdicio_2']+$result->fields['desperdicio_3'];
    $pdf->Cell(23,8,$total_desp);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'P Cuadres y Ajustes');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_paro_g2']));
     $pdf->Cell(40,8,$etiquetas[4]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_5']);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Pequenas Paradas');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_paro_g3']));
     $pdf->Cell(40,8,$etiquetas[5]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_6']);
     
          $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Tiempo Estandar');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_std_prog']));
     $pdf->Cell(40,8,$etiquetas[6]['etiqueta']);
     $pdf->Cell(23,8,$result->fields['indicador_7']);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Tiempo Hombre');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_hombre']));
	 $pdf->Cell(40,8,'Estandar');
     $pdf->Cell(23,8,$estandar);

     $pdf->Ln();
     $pdf->SetTextColor(0, 0, 0);
     $pdf->SetFillColor(100, 100, 100);
     $pdf->SetFont('Arial','I',11);
     $pdf->Cell(40,8,'Tiempo Maquina');
     $pdf->Cell(31,8,$this->tiempo_segundos($result->fields['tiempo_maquina']));
	 $pdf->Cell(40,8,'Unidades Pulso');
     $pdf->Cell(23,8,$unidades_pulso);


      $pdf->Ln();
      $pdf->Cell(40,8,'Observaciones');
      $pdf->Cell(40,8,$asistencia->fields['obsevaciones']);

    $asistencia=$this->listar_turno_asistencia($result->fields['id_turno'],$id_proceso);
    $n_empleados=0;
    while (!$asistencia->EOF) {
    $n_empleados=$n_empleados+1;
    $asistencia->MoveNext();    
    }
    $pdf->Ln();
    $pdf->Ln();
    $asistencia->MoveFirst();
$pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Grupo de trabajo');
    $pdf->Ln();
    $pdf->Cell(60,8,'Empleado ',1,0,'C',true);    
    $pdf->Cell(40,8,'Fecha Inicio ',1,0,'C',true);    
    $pdf->Cell(40,8,'Fecha Fin ',1,0,'C',true);
    $pdf->Cell(40,8,'Tiempo',1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFont('Arial','I',11);
    while (!$asistencia->EOF) {
    $pdf->Cell(60,8,$asistencia->fields["id_empleado"]."-".$asistencia->fields["nombre_persona"]);
    $pdf->Cell(40,8,$result->fields["fecha_inicio"]);
    $pdf->Cell(40,8,$result->fields["fecha_fin"]);
    $pdf->Cell(40,8,$this->tiempo_segundos(($result->fields["tiempo_turno"])));
    $pdf->Ln();
    $asistencia->MoveNext();
    }


    //adjuntar las paradas del turno

     $paradas=$this->listar_turno_paradas($result->fields['id_turno'],$id_proceso);
 $pdf->Ln();
     $pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Paradas de Batch');
    $pdf->Ln();
   
  //  $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
     $pdf->SetFont('Arial','B',9);
    $pdf->Cell(50,6,'Tipo de Parada ',1,0,'C',true);
    $pdf->Cell(33,6,'Fecha Inicio ',1,0,'C',true);
    $pdf->Cell(33,6,'Fecha Fin ',1,0,'C',true);
    $pdf->Cell(30,6,'Grupo',1,0,'C',true);
     $pdf->Cell(22,6,'Tiempo P',1,0,'C',true);
      $pdf->Cell(22,6,'Tiempo',1,0,'C',true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','I',9);
    $t_programado=0;
    $t_total=0;
    while (!$paradas->EOF) {
    $pdf->Cell(50,8,$paradas->fields["id_parada"]."-".$paradas->fields["nombre_parada"],0,0,'L',false);
    $pdf->Cell(33,8,$paradas->fields["fecha_inicio"],0,0,'L',true);
    $pdf->Cell(33,8,$paradas->fields["fecha_fin"]);
    $pdf->Cell(30,8,$this->grupo_paro(($paradas->fields["grupo_parada"])));
    $pdf->Cell(22,8,$this->tiempo_segundos(($paradas->fields["tiempo_programado"])));
    $t_programado=$t_programado+$paradas->fields["tiempo_programado"];
    $pdf->Cell(22,8,$this->tiempo_segundos(($paradas->fields["horas"])));
    $t_total=$t_total+$paradas->fields["horas"];
    $pdf->Ln();
    $paradas->MoveNext();
    }
    $pdf->Cell(83);
    $pdf->Cell(63,6,'Tiempo Total Paradas:',1,0,'C',true);
    $pdf->Cell(22,6,$this->tiempo_segundos($t_programado),1,0,'C',true);
    $pdf->Cell(22,6,$this->tiempo_segundos($t_total),1,0,'C',true);
     $pdf->Ln();

    //fin adjuntar paradas del turno

        $result->MoveNext();
    }
         $pdf->Output();
    }

    function pdf_asistencia($sql,$id_proceso)
    {
        $etiquetas=$this->listar_etiquetas();
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        //ob_end_clean();


    $pdf=new FPDF('P','mm','Letter');
    $pdf->AddPage();
    $pdf->Image('logo2.jpg',10,8,33);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Reporte Asistencia ');
    $pdf->Ln();
    $pdf->Cell(80);
    $pdf->Cell(40,8,$result->fields['nombre']);
    
     while (!$result->EOF) {

 $pdf->SetFont('Arial','B',11);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(30,8,'Batch Numero: ');
  
    $pdf->Cell(10,8,$result->fields['id_turno']);
     $pdf->Cell(15,8,'Orden: ');
     $pdf->Cell(10,8,$result->fields['orden_produccion']);
     $pdf->Cell(10,8,'Producto: ');
     $pdf->Cell(10);
     $pdf->Cell(10,8,$result->fields['id_producto']);
     $pdf->Cell(15);
     $pdf->Cell(40,8,$result->fields['nombre_producto']);

    $asistencia=$this->listar_turno_asistencia($result->fields['id_turno'],$id_proceso);
    $n_empleados=0;
    while (!$asistencia->EOF) {
    $n_empleados=$n_empleados+1;
    $asistencia->MoveNext();
    }
    $pdf->Ln();
   // $pdf->Ln();
    $asistencia->MoveFirst();

    $pdf->SetFillColor(255, 255, 255);
     $pdf->SetFont('Arial','B',11);
    $pdf->Cell(80);

    $pdf->Ln();
    $pdf->Cell(60,6,'Empleado ',1,0,'C',true);
    $pdf->Cell(40,6,'Fecha Inicio ',1,0,'C',true);
    $pdf->Cell(40,6,'Fecha Fin ',1,0,'C',true);
    $pdf->Cell(40,6,'Tiempo',1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFont('Arial','I',11);
    while (!$asistencia->EOF) {
    $pdf->Cell(60,8,$asistencia->fields["id_empleado"]."-".$asistencia->fields["nombre_persona"]);
    $pdf->Cell(40,8,$result->fields["fecha_inicio"]);
    $pdf->Cell(40,8,$result->fields["fecha_fin"]);
    $pdf->Cell(40,8,$this->tiempo_segundos(($result->fields["tiempo_turno"]/$n_empleados)));
    $pdf->Ln();
    $asistencia->MoveNext();
    }

        $result->MoveNext();
    }
         $pdf->Output();
    }

        function pdf_paradas($sql,$id_proceso)
    {
        $etiquetas=$this->listar_etiquetas();
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        //ob_end_clean();

    $pdf=new FPDF('P','mm','Letter');
//$pdf->AddPage();

        $pdf->AddPage();
    $pdf->Image('logo2.jpg',10,8,33);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Reporte Paradas ');
    $pdf->Ln();
    $pdf->Cell(80);
    $pdf->Cell(40,8,$result->fields['nombre']);
    $pdf->Ln();
      $pdf->Ln();
       $pdf->Ln();
    while (!$result->EOF) {

$pdf->SetFont('Arial','B',11);
    $pdf->Cell(30,8,'Batch Numero: ');
  
    $pdf->Cell(10,8,$result->fields['id_turno']);
     $pdf->Cell(15,8,'Orden: ');
     $pdf->Cell(10,8,$result->fields['orden_produccion']);
     $pdf->Cell(10,8,'Producto: ');
     $pdf->Cell(10);
     $pdf->Cell(10,8,$result->fields['id_producto']);
     $pdf->Cell(15);
     $pdf->Cell(40,8,$result->fields['nombre_producto']);
    $paradas=$this->listar_turno_paradas($result->fields['id_turno'],$id_proceso);
    $pdf->Ln();
  //  $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
     $pdf->SetFont('Arial','B',9);
    $pdf->Cell(50,6,'Tipo de Parada ',1,0,'C',true);
    $pdf->Cell(33,6,'Fecha Inicio ',1,0,'C',true);
    $pdf->Cell(33,6,'Fecha Fin ',1,0,'C',true);
    $pdf->Cell(30,6,'Grupo',1,0,'C',true);
     $pdf->Cell(22,6,'Tiempo P',1,0,'C',true);
      $pdf->Cell(22,6,'Tiempo',1,0,'C',true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','I',9);
    $t_programado=0;
    $t_total=0;
    while (!$paradas->EOF) {
    $pdf->Cell(50,8,$paradas->fields["id_parada"]."-".$paradas->fields["nombre_parada"],0,0,'L',false);
    $pdf->Cell(33,8,$paradas->fields["fecha_inicio"],0,0,'L',true);
    $pdf->Cell(33,8,$paradas->fields["fecha_fin"]);
    $pdf->Cell(30,8,$this->grupo_paro(($paradas->fields["grupo_parada"])));
    $pdf->Cell(22,8,$this->tiempo_segundos(($paradas->fields["tiempo_programado"])));
    $t_programado=$t_programado+$paradas->fields["tiempo_programado"];
    $pdf->Cell(22,8,$this->tiempo_segundos(($paradas->fields["horas"])));
    $t_total=$t_total+$paradas->fields["horas"];
    $pdf->Ln();
    $paradas->MoveNext();
    }
    $pdf->Cell(83);
    $pdf->Cell(63,6,'Tiempo Total Paradas:',1,0,'C',true);
    $pdf->Cell(22,6,$this->tiempo_segundos($t_programado),1,0,'C',true);
    $pdf->Cell(22,6,$this->tiempo_segundos($t_total),1,0,'C',true);
     $pdf->Ln();
      $pdf->Ln();
       $pdf->Ln();
        $result->MoveNext();
       
    }
         $pdf->Output();
    }

  function pdf_resumen_turnos($sql,$id_proceso)
    {
        $etiquetas=$this->listar_etiquetas();
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        //ob_end_clean();

    $pdf=new FPDF('P','mm','Letter');
//$pdf->AddPage();

        $pdf->AddPage();
    $pdf->Image('logo2.jpg',10,8,33);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(80);
    $pdf->Cell(40,8,'Resumen General Batchs');
    $pdf->Ln();
    $pdf->Cell(80);
    $pdf->Cell(40,8,$result->fields['nombre']);
    $pdf->Ln();
    $pdf->Ln();
     $pdf->Ln();

    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(15,4,'Batch/Op',0,0,'C',true);
    $pdf->Cell(45,4,'Producto',0,0,'C',true);
    $pdf->Cell(27,4,'Fecha Inicio ',0,0,'C',true);
    $pdf->Cell(27,4,'Fecha Fin ',0,0,'C',true);
    $pdf->Cell(15,4,'Tiempo',0,0,'C',true);
    $pdf->Cell(15,4,'Tiempo',0,0,'C',true);
    $pdf->Cell(15,4,'Tiempo',0,0,'C',true);
    $pdf->Cell(15,4,'Unidades',0,0,'C',true);
    $pdf->Cell(15,4,'Desp.',0,0,'C',true);
    $pdf->Cell(15,4,'Produccion',0,0,'C',true);
 $pdf->Ln();
    $pdf->Cell(12,4);
    $pdf->Cell(45,4);
    $pdf->Cell(27,4);
    $pdf->Cell(27,4);
    $pdf->Cell(15,4,'Total',0,0,'C',true);
    $pdf->Cell(15,4,'Parada',0,0,'C',true);
    $pdf->Cell(15,4,'Estandar',0,0,'C',true);
    $pdf->Cell(15,4,'Conteo',0,0,'C',true);
    $pdf->Cell(15,4);
    $pdf->Cell(15,4,'Final',0,0,'C',true);

    $pdf->Ln();
    $pdf->Cell(12,4);
    $pdf->Cell(45,4);
    $pdf->Cell(27,4);
    $pdf->Cell(27,4);
    $pdf->Cell(15,4,'Parada',0,0,'C',true);
    $pdf->Cell(15,4,'Programa',0,0,'C',true);
    $pdf->Cell(15,4,'Programa',0,0,'C',true);
    $pdf->Cell(15,4,'',0,0,'C',true);
    $pdf->Cell(15,4,'',0,0,'C',true);
    $pdf->Cell(15,4,'',0,0,'C',true);

    $pdf->Line(10, 55, 205, 55);
    $pdf->Ln();
   $pdf->SetFont('Arial','I',7);

   $total_conteo = 0;
   $total_final = 0;
   $t1 = 0;
   $t2 = 0;
   $t3 = 0;
   
    while (!$result->EOF) {
		$desperdicios = $result->fields["desperdicio_1"] + $result->fields["desperdicio_2"] + $result->fields["desperdicio_3"];
		$pdf->Ln();
		$pdf->Cell(15,6,$result->fields["id_turno"]."/".$result->fields["orden_produccion"],0,0,'C',true);
		$pdf->Cell(45,6,$result->fields["nombre_producto"],0,0,'C',true);
		$pdf->Cell(27,6,$result->fields["fecha_inicio"],0,0,'C',true);
		$pdf->Cell(27,6,$result->fields["fecha_fin"],0,0,'C',true);
		$pdf->Cell(15,6,$this->tiempo_segundos($result->fields["tiempo_total_paro"]),0,0,'C',true);
		$pdf->Cell(15,6,$this->tiempo_segundos($result->fields["tiempo_paro_prog"]),0,0,'C',true);
		$pdf->Cell(15,6,$this->tiempo_segundos($result->fields["tiempo_std_prog"]),0,0,'C',true);
		$pdf->Cell(15,6,number_format($result->fields['unidades_conteo'], 0, '', '.'),0,0,'C',true);
		$pdf->Cell(15,6,number_format($desperdicios, 0, '', '.'),0,0,'C',true);
		$pdf->Cell(15,6,number_format($result->fields["produccion_final"], 0, '', '.'),0,0,'C',true);
		$total_conteo=$total_conteo+$result->fields["unidades_conteo"];
		$total_final=$total_final+$result->fields["produccion_final"];
		$total_desperdicio=$total_desperdicio+$desperdicios;
		$t1=$t1+$result->fields["tiempo_total_paro"];
		$t2=$t2+$result->fields["tiempo_paro_prog"];
		$t3=$t3+$result->fields["tiempo_std_prog"];
	$result->MoveNext();
    }
        $pdf->Ln();
     $pdf->SetFont('Arial','B',8);
    $pdf->Cell(12,4);
    $pdf->Cell(70,4);
    $pdf->Cell(32,6,'Totales ',1,0,'C',true);
    $pdf->Cell(15,6,$this->tiempo_segundos($t1),1,0,'C',true);
    $pdf->Cell(15,6,$this->tiempo_segundos($t2),1,0,'C',true);
    $pdf->Cell(15,6,$this->tiempo_segundos($t3),1,0,'C',true);
    
    $pdf->Cell(15,6,number_format($total_conteo, 0, '', '.'),1,0,'C',true);
    $pdf->Cell(15,6,number_format($total_desperdicio, 0, '', '.'),1,0,'C',true);
    $pdf->Cell(15,6,number_format($total_final, 0, '', '.'),1,0,'C',true);

         $pdf->Output();
    }



    function pdf_ordenes_produccion($sql)
    {
       
        include("conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();
        //ob_end_clean();

    $pdf=new FPDF('P','mm','Letter');

     while (!$result->EOF) {

    $datos_op = $this->detalle_OP($result->fields['id_orden_produccion']);

    if($datos_op->fields['nombre_producto']!="")
            {
    $pdf->AddPage();
    $pdf->Image('logo2.jpg',10,8,33);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(70);
    $pdf->Cell(40,8,'Reporte Orden Produccion');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(75);
    $pdf->Cell(40,8,$datos_op->fields["id_orden_produccion"]." - ".$datos_op->fields['nombre_producto']);
    
       $pdf->Ln();
    $pdf->Cell(80);
    $pdf->Cell(40,8,"Unidades:  ".$datos_op->fields['cantidad']);
           $pdf->Ln();
    $pdf->Cell(70);
    $pdf->Cell(40,8,substr($datos_op->fields['fecha_inicio'], 0, 10)." Hasta ".substr($datos_op->fields['fecha_fin'], 0, 10));

     $pdf->Ln();
     $pdf->Ln();
     $pdf->SetFont('Arial','B',9);
     $pdf->Cell(5);
     $pdf->Cell(40,8,"Materiales: ");
     $datos_recetas=$this->listar_recetas($datos_op->fields['id_producto']);

     $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
     
      $pdf->Cell(5);
    $pdf->Cell(33,6,'Codigo ',1,0,'C',true);
    $pdf->Cell(50,6,'Nombre ',1,0,'C',true);
    $pdf->Cell(50,6,'Descripcion ',1,0,'C',true);
    $pdf->Cell(30,6,'Cantidad',1,0,'C',true);
     $pdf->Cell(22,6,'Unidad',1,0,'C',true);
    $pdf->Ln();

    $pdf->SetFont('Arial','I',9);

    while (!$datos_recetas->EOF) {
     $pdf->Cell(5);
    $pdf->Cell(33,6,$datos_recetas ->fields['id_material']);
    $pdf->Cell(50,6,$datos_recetas ->fields['nombre_material']);
    $pdf->Cell(50,6,$datos_recetas->fields['descripcion_material']);
    $pdf->Cell(30,6,($datos_recetas ->fields['cantidad_material']*$datos_op->fields["cantidad"]));
    $pdf->Cell(22,6,$datos_recetas ->fields['unidades_material']);
    $pdf->Ln();
    $datos_recetas->MoveNext();
    }

     $pdf->Ln();

     $pdf->SetFont('Arial','B',9);
     $pdf->Cell(5);
     $pdf->Cell(40,8,"Batchs: ");
     $turnos_op=$this->listar_turnos_op($datos_op->fields["id_orden_produccion"]);

         $pdf->SetFillColor(255, 255, 255);
 $pdf->Ln();
      $pdf->Cell(5);
    $pdf->Cell(33,6,'Batch ',1,0,'C',true);
    $pdf->Cell(50,6,'Proceso',1,0,'C',true);
    $pdf->Cell(40,6,'Fecha Inicio ',1,0,'C',true);
    $pdf->Cell(40,6,'Fecha Final',1,0,'C',true);
     $pdf->Cell(22,6,'Unidades',1,0,'C',true);
    $pdf->Ln();

         $pdf->SetFont('Arial','I',9);
         $total_op=0;
    while (!$turnos_op->EOF) {
     $pdf->Cell(5);
    $pdf->Cell(33,6,$turnos_op ->fields['id_turno']);
    $pdf->Cell(50,6,$turnos_op ->fields['nombre']);
    $pdf->Cell(40,6,$turnos_op ->fields['fecha_inicio']);
    $pdf->Cell(40,6,$turnos_op ->fields['fecha_fin']);
    $pdf->Cell(22,6,$turnos_op ->fields['unidades_conteo']);
    $total_op=$total_op+$turnos_op ->fields['unidades_conteo'];
    $pdf->Ln();
    $turnos_op->MoveNext();
    }
         $pdf->Ln();
 $pdf->Ln();

     $pdf->SetFont('Arial','B',11);
     $pdf->Cell(5);
     $restantes= $datos_op->fields["cantidad"]-$total_op;
     $pdf->Cell(80,8,"Unidades Programadas: ".$datos_op->fields["cantidad"]."   Unidades Producidas: ".$total_op."   Diferencia Unidades : ".$restantes);
            }

        $result->MoveNext();
    }
         $pdf->Output();
    }
}
?>
