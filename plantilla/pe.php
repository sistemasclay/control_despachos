<?php
/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once '../clases/PHPExcel.php';

/** PHPExcel_IOFactory */
require_once '../clases/PHPExcel/IOFactory.php';
require_once '../clases/PHPExcel/Reader/Excel5.php';

$objReader = new PHPExcel_Reader_Excel5();
$objPHPExcel = $objReader->load("Planilla BD Clay VERSION 10.0.xls");


//leer las plantas
echo "plantas";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(1);//plantas
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="")
   {
       $leer_siguiente=0;
   }
   else
   {
   $plantas["id_planta"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   $plantas["nombre"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $plantas["descripcion"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
print_r($plantas);

echo "<br/>";
echo "<br/>";
echo "Procesos";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(2);//procesos
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="")
   {
       $leer_siguiente=0;
   }
   else
   {
   $procesos["id_proceso"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   $procesos["nombre"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $procesos["id_planta"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $procesos["ip"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
   $procesos["max_horas"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
   $procesos["descripcion"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5,$filas_excel)->getValue();
   $procesos["tipo_captura"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
print_r($procesos);


echo "<br/>";
echo "<br/>";
echo "Materiales";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(3);//Materiales
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="")
   {
       $leer_siguiente=0;
   }
   else
   {
   $materiales["id_material"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   $materiales["nombre"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $materiales["descripcion"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $materiales["unidad"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
print_r($materiales);



echo "<br/>";
echo "<br/>";
echo "Productos";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(4);//echo "Productos";

$leer_siguiente=1;
$filas_excel=3;
$indice_array_producto=0;
$indice_array_p_p=0;
$indice_array_receta=0;
$producto_eva="";//para comparar que no se repita
$pp_eval="";
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="") //si llego al final sale del while
   {
       $leer_siguiente=0;
   }
   else
   {
                if($producto_eva!=$valor_celda) //si el no esta repetido
                {
                $productos["id_producto"][$indice_array_producto]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
                $productos["nombre"][$indice_array_producto]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
                $productos["descripcion"][$indice_array_producto]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();

                $producto_p["id_producto"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
                $producto_p["id_proceso"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9,$filas_excel)->getValue();
                $producto_p["unidades_pulso"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10,$filas_excel)->getValue();
                $producto_p["var_pp1"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11,$filas_excel)->getValue();

                $res=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20,$filas_excel)->getValue();
                if($res!="") //si hay receta
                {
                $receta["id_producto"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
                $receta["id_material"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20,$filas_excel)->getValue();
                $receta["cantidad"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21,$filas_excel)->getValue();
                $indice_array_receta++;
                }

                $producto_eva=$productos["id_producto"][$indice_array_producto];
                $pp_eval=$producto_p["id_proceso"][$indice_array_p_p];
                $indice_array_producto++;
                $indice_array_p_p++;
                }
                else
                {
                    if($pp_eval!=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9,$filas_excel)->getValue()) //si el no esta repetido
                    {
                    $producto_p["id_producto"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
                    $producto_p["id_proceso"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9,$filas_excel)->getValue();
                    $producto_p["unidades_pulso"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10,$filas_excel)->getValue();
                    $producto_p["var_pp1"][$indice_array_p_p]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11,$filas_excel)->getValue();
                    $pp_eval=$producto_p["id_proceso"][$indice_array_p_p];
                     $indice_array_p_p++;
                    }
                $res=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20,$filas_excel)->getValue();
                if($res!="") //si hay receta
                {
                $receta["id_producto"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
                $receta["id_material"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20,$filas_excel)->getValue();
                $receta["cantidad"][$indice_array_receta]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(21,$filas_excel)->getValue();
                $indice_array_receta++;
                }
                $producto_eva=$valor_celda;
                }
    $filas_excel++;
   }
}
print_r($productos["id_producto"]);
echo "<br/>";
echo "<br/>";
echo "Producto Proceso";
echo "<br/>";
print_r($producto_p);
echo "<br/>";
echo "<br/>";
echo "recetas";
echo "<br/>";
print_r($receta["cantidad"]);


echo "<br/>";
echo "<br/>";
echo "Empleados";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(6);//Empleados
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="")
   {
       $leer_siguiente=0;
   }
   else
   {
   $empleados["id_empleado"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   $empleados["nombre"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $empleados["cargo"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $empleados["clave"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
   $empleados["nivel"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
print_r($empleados);



echo "<br/>";
echo "<br/>";
echo "Paradas";
echo "<br/>";
$objPHPExcel->setActiveSheetIndex(7);//Paradas
$leer_siguiente=1;
$filas_excel=3;
$indice_array=0;
$valor_celda="";
while($leer_siguiente==1)
{
   $valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   if($valor_celda=="")
   {
       $leer_siguiente=0;
   }
   else
   {
   $paradas["id_parada"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$filas_excel)->getValue();
   $paradas["nombre"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$filas_excel)->getValue();
   $paradas["tipo"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$filas_excel)->getValue();
   $paradas["grupo"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,$filas_excel)->getValue();
   $paradas["unidad"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4,$filas_excel)->getValue();
   $paradas["tiempo_prog"][$indice_array]=$valor_celda=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6,$filas_excel)->getValue();
   $filas_excel++;
   $indice_array++;
   }
}
print_r($paradas);


?>
