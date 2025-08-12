<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mesObtenido = $_POST['mes'];
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"]; 
$dia = $_POST["dia"];
$anio = $_POST["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroProgramas = "DATE(a.AF_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroCortesia = "DATE(a.IC_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroHotel = "DATE(A.IH_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroTar = "DATE(A.ITF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) = '$dia'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) = '$dia'";
 $filtroProgramas = "DATE(a.AF_FECHA) = '$dia'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) = '$dia'";
 $filtroCortesia = "DATE(a.IC_FECHA) = '$dia'";
 $filtroHotel = "DATE(A.IH_FECHA) = '$dia'";
 $filtroTar = "DATE(A.ITF_FECHA) = '$dia'";
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroAsociados = "YEAR(DATE(A.IA_FECHA_INGRESO)) = '$anio'";
 $filtroNoA = "YEAR(DATE(a.INA_FECHA_INGRESO)) = '$anio'";
 $filtroProgramas = "YEAR(DATE(a.AF_FECHA)) = '$anio'";
 $filtroEvento = "YEAR(DATE(a.IE_FECHA_EVENTO)) = '$anio'";
 $filtroCortesia = "YEAR(DATE(a.IC_FECHA)) = '$anio'";
 $filtroHotel = "YEAR(DATE(A.IH_FECHA))= '$anio'";
 $filtroTar = "YEAR(DATE(A.ITF_FECHA))= '$anio'";
}
elseif($mesObtenido!="")
{
  $mesSelect = date("m",strtotime($mesObtenido));
  $year = date("Y",strtotime($mesObtenido));
 $texto = "Del mes ".$mesSelect." y el año ".$year;
 $filtroAsociados = "MONTH(DATE(A.IA_FECHA_INGRESO)) = '$mesSelect' AND YEAR(DATE(A.IA_FECHA_INGRESO)) = '$year'";
 $filtroNoA = "MONTH(DATE(a.INA_FECHA_INGRESO)) = '$mesSelect' AND YEAR(DATE(a.INA_FECHA_INGRESO)) = '$year'";
 $filtroProgramas = "MONTH(DATE(a.AF_FECHA)) = '$mesSelect' AND YEAR(DATE(a.AF_FECHA)) = '$year'";
 $filtroEvento = "MONTH(DATE(a.IE_FECHA_EVENTO)) = '$mesSelect' AND YEAR(DATE(a.IE_FECHA_EVENTO)) = '$year'";
 $filtroCortesia = "MONTH(DATE(a.IC_FECHA)) = '$mesSelect' AND YEAR(DATE(a.IC_FECHA)) = '$year'";
 $filtroHotel = "MONTH(DATE(A.IH_FECHA))= '$mesSelect' AND YEAR(DATE(A.IH_FECHA))= '$year'";
 $filtroTar = "MONTH(DATE(A.ITF_FECHA))= '$mesSelect' AND YEAR(DATE(A.ITF_FECHA))= '$year'";
}
//ASOCIADOS
$selectAsociados = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE $filtroAsociados
GROUP BY DAY(A.IA_FECHA_INGRESO), A.IAT_CIF_ASOCIADO
");
$mayor =0;
$menor= 0;
$menor5=0;
while($rowTarAdultos = mysqli_fetch_array($selectAsociados))
{
  $edad = Saber_Edad_Asociado($rowTarAdultos['IAT_CIF_ASOCIADO']);

  if ($edad>18) {
    $mayor ++; 
  }
  elseif($edad > 4 && $edad <= 18)
  {
    $menor++; 
  }
  else
    { 
    $menor5++;
    } 
}
 


$asociadosAcomp = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados  
 "));

 
//no asociados
$noAsociadosAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_ADULTO>0  
 "));

$noAsociadosNino = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_NINIO>0  
 "));

//HOTELES
$selectHotel = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.IH_ADULTOS) AS ADULTOS, SUM(A.IH_NINOS) AS MENORES, SUM(A.IH_MENORES_5) AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE $filtroHotel
"));


 //tarjetas insert
$selectTarj = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar
"));
 
//MENORES 5 AÑOS INSERT 

$selectUpdMenor = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS MENORES5 FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE $filtroNoA AND a.INA_NINIO_MENOR_5>0  "));

  
//EJERCICIOS

$selectEjercicios = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE $filtroProgramas AND a.PA_ID IN (6,8)"));
  
//FORMACION

$selectFormacion = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE $filtroProgramas AND a.CE_ID = 1
 ")); 
//EVENTOS INSERT

$selectEventos = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IE_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_EVENTO a
WHERE $filtroEvento "));
 

//CORTESIAS INSERT

$selectCortesia = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IC_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_CORTESIA a
WHERE $filtroCortesia"));


$totalAsociados = $mayor+$asociadosAcomp["total"]+$menor+$selectEjercicios["SUMA"]+$selectFormacion["SUMA"];
$totalIV = $selectTarj["MENORES5"]+$selectHotel["MENORES5"]+$selectUpdMenor["MENORES5"]+$selectEventos["SUMA"]+$selectCortesia["SUMA"]+$menor5;
$totalNoAsociados = $noAsociadosAdulto["SUMA"]+$noAsociadosNino["SUMA"]+$selectHotel["ADULTOS"]+$selectHotel["MENORES"]+$selectTarj["ADULTOS"]+$selectTarj["NINOS"];
$totalNoAsociado = $totalIV+$totalNoAsociados;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }

        table th {
	  color: #fff;
	  background-color: #f00;
	}
    </style>

</head>
 
	<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style> 
<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance

var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
// Add data
chart.data = [ {
  "country": "ASOCIADOS",
  "litres": <?php echo $totalAsociados?>
}, {
  "country": "NO ASOCIADOS",
  "litres": <?php echo $totalNoAsociado?>
} ]; 
var texto = <?php echo $totalAsociados ?>;
var texto1 = <?php echo $totalNoAsociado ?>;
var texto2 = <?php echo $totalAsociados+$totalNoAsociado ?>;
// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;
var title2 = chart.titles.create();
title2.text = "TOTAL:"+texto2;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = "NO ASOCIADOS:"+texto1;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = "ASOCIADOS:"+texto;
title.fontSize = 18;
title.align = "left";
var titleText = chart.titles.create();
titleText.text = "INGRESOS ASOCIADOS Y NO ASOCIADOS";
titleText.fontSize = 18; 
titleText.align = "center";


chart.exporting.menu = new am4core.ExportMenu();

}); // end am4core.ready()

</script>

<!-- HTML -->
<div id="chartdiv"></div>		    		
</html>
