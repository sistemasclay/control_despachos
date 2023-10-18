<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of teimpo real
 * esta clase esta asociada a la informacion del dash board de las maquinas del
 * sistema.
 * @author Juan Pablo salazar
 */
include("../clases/adodb5/adodb-exceptions.inc.php");
include("../clases/adodb5/adodb.inc.php");

class interfaz_clase {

    function ejecutar_consulta($sql)
    {
        include("../clases/conexion.php");      
        $result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
		echo 'error al consultar: '.$conexion_pg->ErrorMsg().'<BR>';			
		}
		$conexion_pg->Close();
		return $result;
    }

function traer_turnos($fechaHoraActual)
{
	$sql="select T1.* from (SELECT t.id_proceso,t.id_turno,t.orden_produccion,t.fecha_inicio,t.dato_extra,t.fecha_fin,t.unidades_conteo,t.produccion_final,p.nombre
FROM turnos as t, procesos as p where t.id_proceso=p.id_proceso) as T1 where to_char(fecha_inicio,'yyyy-mm-dd')=to_char(to_date('$fechaHoraActual','yyyy-mm-dd') - 1 * interval '1 day','yyyy-mm-dd')
or to_char(fecha_fin,'yyyy-mm-dd')=to_char(to_date('$fechaHoraActual','yyyy-mm-dd') - 1 * interval '1 day','yyyy-mm-dd') order by id_proceso,id_turno";	
	$turnos=$this->ejecutar_consulta($sql);	
	$arr = $turnos->getArray();
	$conturnos=count($arr);
	
	//fecha para evaluar si el turno inicio un dia antes de la fech de sleeccion
		$finit=date('Y-m-d',strtotime($fechaHoraActual." - 2 day"));		
		//fecha para evaluar si el turno finalizo un dia despues de la fech de sleeccion
		$ffint=date('Y-m-d',strtotime($fechaHoraActual));		
	
for($i=0;$i<$conturnos;$i++)
{
		$fechabdinit=date('Y-m-d',strtotime($arr[$i]["fecha_inicio"]));		
		$fechabdfint=date('Y-m-d',strtotime($arr[$i]["fecha_fin"]));			
		if($fechabdinit==$finit)//si este inicio  el dia anterior a la seleccion se cambia la fecha por la seleccion 00:00:00
		$arr[$i]["fecha_inicio"]=date('Y-m-d',strtotime($fechaHoraActual." - 1 day"))." 00:00:00";
		if($fechabdfint==$ffint)//si este finalizo  el dia despues a la seleccion se cambia la fecha por la seleccion 23:59:59
		$arr[$i]["fecha_fin"]=date('Y-m-d',strtotime($fechaHoraActual." - 1 day"))." 23:59:59";
	}	
	
	return $arr;
	}
	
function traer_operarios_turno($id_turno,$id_proceso,$fechainicio,$fechafin)
{
	$sql="select id_empleado, '0' as traslapo from turno_asistencia where id_turno='".$id_turno."' and id_proceso='".$id_proceso."'";
	$operarios_turno=$this->ejecutar_consulta($sql);	
	$Aoperarios_turno=$operarios_turno->getArray();
	$Cperarios_turno=count($Aoperarios_turno);
	
	for($i=0;$i<$Cperarios_turno;$i++)
	{
		 $sql="select count(*) from turnos as t, turno_asistencia as ta where 
ta.id_turno = t.id_turno and ta.id_proceso=t.id_proceso and t.fecha_inicio>='".$fechainicio."' and t.fecha_inicio <='".$fechafin."'
and ta.id_empleado='".$Aoperarios_turno[$i][id_empleado]."'";
$empledos_translapo=$this->ejecutar_consulta($sql);	
$Aempledos_translapo=$empledos_translapo->getArray();

if($Aempledos_translapo[0][count]>=2)
	{
		$Aoperarios_turno[$i][traslapo]="S";
		}
		else
		{
		$Aoperarios_turno[$i][traslapo]="N";
		}
	}
	return $Aoperarios_turno;	
}

function traer_paradas_turno($id_turno,$id_proceso,$fechaHoraActual)
{
	$sql="SELECT T1.* FROM
(SELECT tp.id_turno,tp.id_proceso,p.nombre,tp.fecha_inicio,tp.fecha_fin,tp.id_parada,tp.horas,tp.unidades,pa.tipo_parada 
 from turno_parada as tp, procesos as p, paradas as pa where tp.id_parada = pa.id_parada and  tp.id_proceso=p.id_proceso and tp.id_turno='".$id_turno."' and tp.id_proceso='".$id_proceso."' order by tp.fecha_inicio) AS T1 WHERE 
to_char(fecha_inicio,'yyyy-mm-dd')=to_char(to_date('$fechaHoraActual','yyyy-mm-dd') - 1 * interval '1 day','yyyy-mm-dd') 
or to_char(fecha_fin,'yyyy-mm-dd')=to_char(to_date('$fechaHoraActual','yyyy-mm-dd') - 1 * interval '1 day','yyyy-mm-dd') order by fecha_inicio";

	$paradas_turno=$this->ejecutar_consulta($sql);	
	$Aparadas_turno=$paradas_turno->getArray();
	$Cparadas_turno=count($Aparadas_turno);
		//fecha para evaluar si el turno inicio un dia antes de la fech de sleeccion
		$finit=date('Y-m-d',strtotime($fechaHoraActual." - 2 day"));		
		//fecha para evaluar si el turno finalizo un dia despues de la fech de sleeccion
		$ffint=date('Y-m-d',strtotime($fechaHoraActual));		
	for($i=0;$i<$Cparadas_turno;$i++)
	{
		$fechabdinit=date('Y-m-d',strtotime($Aparadas_turno[$i]["fecha_inicio"]));		
		$fechabdfint=date('Y-m-d',strtotime($Aparadas_turno[$i]["fecha_fin"]));			
		if($fechabdinit==$finit)//si este inicio  el dia anterior a la seleccion se cambia la fecha por la seleccion 00:00:00
		$Aparadas_turno[$i]["fecha_inicio"]=date('Y-m-d',strtotime($fechaHoraActual." - 1 day"))." 00:00:00";
		if($fechabdfint==$ffint)//si este finalizo  el dia despues a la seleccion se cambia la fecha por la seleccion 23:59:59
		$Aparadas_turno[$i]["fecha_fin"]=date('Y-m-d',strtotime($fechaHoraActual." - 1 day"))." 23:59:59";
	}
	return $Aparadas_turno;
}

function probar0($fecha)
{
	$hora= date("H:i:s",strtotime($fecha));
	if($hora=="00:00:00")
	{
		$result=true;
		}
		else
		{
			$result=false;
			}	
	}
	
	function probar24($fecha)
{
	$hora= date("H:i:s",strtotime($fecha));
		if($hora=="23:59:59")
	{
		$result=true;
		}
		else
		{
			$result=false;
			}
	
	}

}
?>

