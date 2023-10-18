<?

class conversiones_fechas {

//ex: 2007-08-02 16:48:26

//--Salida--
//$valores['anno'] $valores['mes'] $valores['dia']
//$valores['hora'] $valores['min'] $valores['seg']
function getValores($fecha)
{
list($fechaT, $horaT) = explode(" ",$fecha);

list($anno,$mes,$dia) = explode("-",$fechaT);
list($hora,$min,$seg) = explode(":",$horaT);

$valores=array("anno" => $anno, "mes" => $mes, "dia" => $dia, "hora" => $hora, "min" => $min, "seg" => $seg);
return $valores;
}
//------------------------------------------------------------------------------


//--Salida--
//1170889200
function getTimeUNIX($anno, $mes, $dia)
{
return mktime(0, 0, 0, $mes, $dia, $anno);
}
//------------------------------------------------------------------------------


//--Salida--
//1170949706
function getTimeUNIXall($anno, $mes, $dia, $hora, $min, $seg)
{
return mktime($hora, $min, $seg, $mes, $dia, $anno);
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha => ex: 2007-08-02 16:48:26

//--Salida--
//1170889200
function getTimeUNIX_BD($fecha)
{
$valores=$this->getValores($fecha);
return $this->getTimeUNIXall($valores['anno'], $valores['mes'], $valores['dia'], $valores['hora'], $valores['min'], $valores['seg']);
}
//------------------------------------------------------------------------------


//--Entrada--
//$string => ex: "now" "10 September 2000" "+1 day" "+1 week" "+1 week 2 days 4 hours 2 seconds" "+1 month" "next Thursday" "last Monday"
//$timeStamp => ex: 1170889200

//--Salida--
//1170889200
function getTimeUNIXFechaFinal($string,$timeStamp)
{
return strtotime($string, $timeStamp);
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp => ex: 1170889200

//--Salida--
//2007-08-16
function getFechaYMD($timeStamp)
{
return date("Y-m-d", $timeStamp);
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha => ex: 2007-08-02 16:48:26

//--Salida--
//2007-08-02
function getFechaYMD_BD($fecha)
{
return date("Y-m-d", getTimeUNIX_BD($fecha));
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp => ex: 1170889200

//--Salida--
//16:48:26
function getFechaHIS($timeStamp)
{
return date("H:i:s", $timeStamp);
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha => ex: 2007-08-02 16:48:26

//--Salida--
//16:48:26
function getFechaHIS_BD($fecha)
{
return date("H:i:s", getTimeUNIX_BD($fecha));
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp => ex: 1170889200

//--Salida--
// 2007-02-08 16:48:26
function getFechaYMD_HIS($timeStamp)
{
$fecha=getFechaYMD($timeStamp) . ' ' . getFechaHIS($timeStamp);
return $fecha;
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp1(fecha final) => ex: 1170889200
//$timeStamp2(fecha inicial) => ex: 1170889230

//--Salida--
// 3 horas
function getDifFechasH($timeStamp1, $timeStamp2)
{
return floor(abs(($timeStamp1-$timeStamp2)/3600));//3600 =>60 * 60
   
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp1(fecha final) => ex: 1170889200
//$timeStamp2(fecha inicial) => ex: 1170889230

//--Salida--
// 45 days
function getDifFechasD($timeStamp1, $timeStamp2)
{
return floor(abs(($timeStamp1-$timeStamp2)/86400));//86400 =>24 * 60 * 60
}
//------------------------------------------------------------------------------


//--Entrada--
//$timeStamp1(fecha final) => ex: 1170889200
//$timeStamp2(fecha inicial) => ex: 1170889230

//--Salida--
// 1 mes
function getDifFechasM($timeStamp1, $timeStamp2)
{
return floor(abs(($timeStamp1-$timeStamp2)/2592000));//2592000 =>30 * 24 * 60 * 60
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha1(fecha final) => ex: 2007-09-02 16:48:26
//$fecha2(fecha inicial) => ex: 2007-08-02 16:48:26

//--Salida--
// 3 horas
function getDifFechasH_BD($fecha1, $fecha2)
{
//return $this->getDifFechasH($this->getTimeUNIX_BD($fecha1), $this->getTimeUNIX_BD($fecha2));
    return $this->getDifFechasH($this->getTimeUNIXall($fecha1), $this->getTimeUNIXall($fecha2));
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha1(fecha final) => ex: 2007-09-02 16:48:26
//$fecha2(fecha inicial) => ex: 2007-08-02 16:48:26

//--Salida--
// 45 days
function getDifFechasD_BD($fecha1, $fecha2)
{
return getDifFechasD(getTimeUNIX_BD($fecha1), getTimeUNIX_BD($fecha2));
}
//------------------------------------------------------------------------------


//--Entrada--
//$fecha1(fecha final) => ex: 2007-09-02 16:48:26
//$fecha2(fecha inicial) => ex: 2007-08-02 16:48:26

//--Salida--
// 1 mes
function getDifFechasM_BD($fecha1, $fecha2)
{
return getDifFechasM(getTimeUNIX_BD($fecha1), getTimeUNIX_BD($fecha2));
}
//------------------------------------------------------------------------------

function getDifFechas1($timeStamp1, $timeStamp2)
{
    return floor(abs($timeStamp1-$timeStamp2));//3600 =>60 * 60
}

function getDifFechastodo($fecha1, $fecha2)
{
//return $this->getDifFechasH($this->getTimeUNIX_BD($fecha1), $this->getTimeUNIX_BD($fecha2));
    $fecha11=$this->getValores($fecha1);
     $fecha22=$this->getValores($fecha2);
    return $this->getDifFechas1($this->getTimeUNIXall($fecha11["anno"],$fecha11["mes"],$fecha11["dia"],$fecha11["hora"],$fecha11["min"],$fecha11["seg"]), $this->getTimeUNIXall($fecha22["anno"],$fecha22["mes"],$fecha22["dia"],$fecha22["hora"],$fecha22["min"],$fecha22["seg"]));
}


    function listar_formulas()
    {
        include("conexion.php");
 //  $sql ="SELECT * FROM recetas as b INNER JOIN materiales as a ON (b.id_material= a.id_material) WHERE id_producto='$producto'";
       $sql = "SELECT * FROM formulas  order by id_formula";
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
         return $result;
    }

}

?>