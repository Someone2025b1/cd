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
$mes = date("m",strtotime($mesObtenido));
$year = date("Y",strtotime($mesObtenido));

if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = fecha_con_mes($fechaInicial)." al ".fecha_con_mes($fechaFinal);
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
 $texto = fecha_con_mes($dia);
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
 $texto = $anio;
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
 $texto = $mes."-".$year;
 $filtroAsociados = "MONTH(DATE(A.IA_FECHA_INGRESO)) = '$mes' and YEAR(DATE(A.IA_FECHA_INGRESO)) = $year";
 $filtroNoA = "MONTH(DATE(a.INA_FECHA_INGRESO)) = '$mes' and YEAR(DATE(a.INA_FECHA_INGRESO)) = $year";
 $filtroProgramas = "MONTH(DATE(a.AF_FECHA)) = '$mes' and YEAR(DATE(a.AF_FECHA)) = $year";
 $filtroEvento = "MONTH(DATE(a.IE_FECHA_EVENTO)) = '$mes' and YEAR(DATE(a.IE_FECHA_EVENTO)) = $year";
 $filtroCortesia = "MONTH(DATE(a.IC_FECHA)) = '$mes' and YEAR(DATE(a.IC_FECHA)) = $year";
 $filtroHotel = "MONTH(DATE(A.IH_FECHA))= '$mes' and YEAR(DATE(A.IH_FECHA)) = $year";
 $filtroTar = "MONTH(DATE(A.ITF_FECHA))= '$mes' and YEAR(DATE(A.ITF_FECHA)) = $year";
}

//ASOCIADOS
$asociadosTitular = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) as total 
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE $filtroAsociados
 "));


$asociadosAcomp = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados AND A.IAT_NOMBRE != ' ' AND A.IAT_EDAD >=18
 "));

$asociadosNino = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados AND A.IAT_NOMBRE != ' ' AND A.IAT_EDAD <18
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
 

$totalNoAsociado = $noAsociadosAdulto["SUMA"]+$noAsociadosNino["SUMA"]+$selectHotel["ADULTOS"]+$selectHotel["MENORES5"]+$selectHotel["MENORES"]+$selectTarj["ADULTOS"]+$selectTarj["NINOS"]+$selectTarj["MENORES5"]+$selectUpdMenor["MENORES5"]+$selectEventos["SUMA"]+$selectCortesia["SUMA"];

$totalAsociados = $asociadosNino["total"]+$asociadosAcomp["total"]+$asociadosTitular["total"]+$selectEjercicios["SUMA"]+$selectFormacion["SUMA"];

$totalIngresos1 = $totalNoAsociado+$totalAsociados;

//ingresos dato 2
$mesObtenido2 = $_POST['mes2']; 
$dia2 = $_POST["dia2"];
$anio2 = $_POST["anio2"];
$fechaInicial2 = $_POST["fechaInicial2"];
$fechaFinal2 = $_POST["fechaFinal2"];
$mes2 = date("m",strtotime($mesObtenido2));
$year2 = date("Y",strtotime($mesObtenido2));

if ($fechaInicial2 != "" and $fechaFinal2!="") 
{
 $texto2 = fecha_con_mes($fechaInicial2)." al ".fecha_con_mes($fechaFinal2);
 $filtroAsociados2 = "DATE(A.IA_FECHA_INGRESO) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
 $filtroNoA2 = "DATE(a.INA_FECHA_INGRESO) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
 $filtroProgramas2 = "DATE(a.AF_FECHA) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
 $filtroEvento2 = "DATE(a.IE_FECHA_EVENTO) BETWEEN '$fechaInicial2' AND '$fechaFinal2'";
 $filtroCortesia2 = "DATE(a.IC_FECHA) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
 $filtroHotel2 = "DATE(A.IH_FECHA) BETWEEN '$fechaInicial2' AND '$fechaFinal2'";
 $filtroTar2 = "DATE(A.ITF_FECHA) BETWEEN '$fechaInicial2' AND '$fechaFinal2'";
}
elseif($dia2!="")
{
 $texto2 = fecha_con_mes($dia2);
 $filtroAsociados2 = "DATE(A.IA_FECHA_INGRESO) = '$dia2'";
 $filtroNoA2 = "DATE(a.INA_FECHA_INGRESO) = '$dia2'";
 $filtroProgramas2 = "DATE(a.AF_FECHA) = '$dia2'";
 $filtroEvento2 = "DATE(a.IE_FECHA_EVENTO) = '$dia2'";
 $filtroCortesia2 = "DATE(a.IC_FECHA) = '$dia2'";
 $filtroHotel2 = "DATE(A.IH_FECHA) = '$dia2'";
 $filtroTar2 = "DATE(A.ITF_FECHA) = '$dia2'";
}
elseif($anio2!="")
{
 $texto2 = $anio2;
 $filtroAsociados2 = "YEAR(DATE(A.IA_FECHA_INGRESO)) = '$anio2'";
 $filtroNoA2 = "YEAR(DATE(a.INA_FECHA_INGRESO)) = '$anio2'";
 $filtroProgramas2 = "YEAR(DATE(a.AF_FECHA)) = '$anio2'";
 $filtroEvento2 = "YEAR(DATE(a.IE_FECHA_EVENTO)) = '$anio2'";
 $filtroCortesia2 = "YEAR(DATE(a.IC_FECHA)) = '$anio2'";
 $filtroHotel2 = "YEAR(DATE(A.IH_FECHA))= '$anio2'";
 $filtroTar2 = "YEAR(DATE(A.ITF_FECHA))= '$anio2'";
}
elseif($mesObtenido2!="")
{
 $texto2 = $mes2."-".$year2;
 $filtroAsociados2 = "MONTH(DATE(A.IA_FECHA_INGRESO)) = '$mes2' and YEAR(DATE(A.IA_FECHA_INGRESO)) = $year2";
 $filtroNoA2 = "MONTH(DATE(a.INA_FECHA_INGRESO)) = '$mes2' and YEAR(DATE(a.INA_FECHA_INGRESO)) = $year2";
 $filtroProgramas2 = "MONTH(DATE(a.AF_FECHA)) = '$mes2' and YEAR(DATE(a.AF_FECHA)) = $year2";
 $filtroEvento2 = "MONTH(DATE(a.IE_FECHA_EVENTO)) = '$mes2' and YEAR(DATE(a.IE_FECHA_EVENTO)) = $year2";
 $filtroCortesia2 = "MONTH(DATE(a.IC_FECHA)) = '$mes2' and YEAR(DATE(a.IC_FECHA)) = $year2";
 $filtroHotel2 = "MONTH(DATE(A.IH_FECHA))= '$mes2' and YEAR(DATE(A.IH_FECHA)) = $year2";
 $filtroTar2 = "MONTH(DATE(A.ITF_FECHA))= '$mes2' and YEAR(DATE(A.ITF_FECHA)) = $year2";
}
//ASOCIADOS
$asociadosTitular2 = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) as total 
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE $filtroAsociados2"));


$asociadosAcomp2= mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados2 AND A.IAT_NOMBRE != ' ' AND A.IAT_EDAD >=18
 "));

$asociadosNino2 = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados2 AND A.IAT_NOMBRE != ' ' AND A.IAT_EDAD <18
 "));

//no asociados
$noAsociadosAdulto2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA2 AND a.INA_ADULTO>0  
 "));

$noAsociadosNino2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA2 AND a.INA_NINIO>0  
 "));

//HOTELES
$selectHotel2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.IH_ADULTOS) AS ADULTOS, SUM(A.IH_NINOS) AS MENORES, SUM(A.IH_MENORES_5) AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE $filtroHotel2
"));

 //tarjetas insert
$selectTarj2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar2
"));

//MENORES 5 AÑOS INSERT 

$selectUpdMenor2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS MENORES5 FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE $filtroNoA2 AND a.INA_NINIO_MENOR_5>0  "));
  
//EJERCICIOS

$selectEjercicios2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE $filtroProgramas2 AND a.PA_ID IN (6,8)"));

//FORMACION

$selectFormacion2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE $filtroProgramas2 AND a.CE_ID = 1
 ")); 
//EVENTOS INSERT

$selectEventos2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IE_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_EVENTO a
WHERE $filtroEvento2 "));
 

//CORTESIAS INSERT

$selectCortesia2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IC_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_CORTESIA a
WHERE $filtroCortesia2"));
 

$totalNoAsociado2 = $noAsociadosAdulto2["SUMA"]+$noAsociadosNino2["SUMA"]+$selectHotel2["ADULTOS"]+$selectHotel2["MENORES5"]+$selectHotel2["MENORES"]+$selectTarj2["ADULTOS"]+$selectTarj2["NINOS"]+$selectTarj2["MENORES5"]+$selectUpdMenor2["MENORES5"]+$selectEventos2["SUMA"]+$selectCortesia2["SUMA"];

$totalAsociados2 = $asociadosNino2["total"]+$asociadosAcomp2["total"]+$asociadosTitular2["total"]+$selectEjercicios2["SUMA"]+$selectFormacion2["SUMA"];

$totalIngresos2 = $totalNoAsociado2+$totalAsociados2;
$incremento = $totalIngresos1-$totalIngresos2;
$incremento1 = $totalAsociados-$totalAsociados2;
$incremento2 = $totalNoAsociado-$totalNoAsociado2;
if ($incremento>0) {
  $diferenciaTexto = "INCREMENTO";
}
else
{
  $diferenciaTexto = "DISMINUCION";
}
if ($incremento1>0) {
  $diferenciaTexto1 = "INCREMENTO";
}
else
{
  $diferenciaTexto1 = "DISMINUCION";
}

if ($incremento2>0) {
  $diferenciaTexto2 = "INCREMENTO";
}
else
{
  $diferenciaTexto2 = "DISMINUCION";
}
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
#chartdiv1 {
  width: 100%;
  height: 500px;
}
#chartdiv2 {
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
var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [{
  "country": '<?php echo $texto?>'+': '+'<?php echo $totalIngresos1 ?>',
  "visits": <?php echo $totalIngresos1?>
}, {
  "country": '<?php echo $texto2?>'+': '+'<?php echo $totalIngresos2 ?>',
  "visits": <?php echo $totalIngresos2?>
}, {
  "country": '<?php echo $diferenciaTexto?>'+': '+'<?php echo $incremento ?>',
  "visits": <?php echo $incremento?>
}];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
var incremento = <?php echo $incremento ?>;
var t1= <?php echo $totalIngresos1 ?>;
var t2= <?php echo $totalIngresos2 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto?> :'+incremento;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": "+t1;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": "+t2;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "INGRESOS TOTALES AL PARQUE";
title.fontSize = 25;
title.marginBottom = 30;
chart.exporting.menu = new am4core.ExportMenu();

}); // end am4core.ready()

</script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv1", am4charts.XYChart);

// Export
chart.exporting.menu = new am4core.ExportMenu();

// Data for both series
var data = [ {
  "year": '<?php echo $texto?>'+': '+'<?php echo $totalAsociados ?>',
  "income": <?php echo $totalAsociados?>
}, {
  "year": '<?php echo $texto2?>'+': '+'<?php echo $totalAsociados2 ?>',
  "income": <?php echo $totalAsociados2?>
}, {
  "year": '<?php echo $diferenciaTexto1 ?>'+': '+'<?php echo $incremento1 ?>',
  "income": <?php echo $totalAsociados-$totalAsociados2?>
} ];

/* Create axes */
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.minGridDistance = 30;

/* Create value axis */
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

/* Create series */
var columnSeries = chart.series.push(new am4charts.ColumnSeries());
columnSeries.name = "";
columnSeries.dataFields.valueY = "income";
columnSeries.dataFields.categoryX = "year";

columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}"
columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
columnSeries.columns.template.propertyFields.stroke = "stroke";
columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
columnSeries.tooltip.label.textAlign = "middle";

var lineSeries = chart.series.push(new am4charts.LineSeries());
lineSeries.name = "Expenses";
lineSeries.dataFields.valueY = "expenses";
lineSeries.dataFields.categoryX = "year";

lineSeries.stroke = am4core.color("#fdd400");
lineSeries.strokeWidth = 3;
lineSeries.propertyFields.strokeDasharray = "lineDash";
lineSeries.tooltip.label.textAlign = "middle";

var bullet = lineSeries.bullets.push(new am4charts.Bullet());
bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
bullet.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
var circle = bullet.createChild(am4core.Circle);
circle.radius = 4;
circle.fill = am4core.color("#fff");
circle.strokeWidth = 3;

chart.data = data;
var incremento1 = <?php echo $incremento1 ?>;
var t11= <?php echo $totalAsociados ?>;
var t22= <?php echo $totalAsociados2 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto1?>'+": "+incremento1;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": "+t11;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": "+t22;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "INGRESOS ASOCIADOS AL PARQUE";
title.fontSize = 25;
title.marginBottom = 30;
chart.exporting.menu = new am4core.ExportMenu();

}); // end am4core.ready()
</script>
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.XYChart);

// Add percent sign to all numbers
chart.numberFormatter.numberFormat = "#.#";

// Add data
chart.data = [{
    "country": '<?php echo $texto?>'+': '+'<?php echo $totalNoAsociado ?>',
    "year2004": <?php echo $totalNoAsociado?>
}, {
    "country": '<?php echo $texto2?>'+': '+'<?php echo $totalNoAsociado2 ?>',
    "year2004": <?php echo $totalNoAsociado2?>
}, {
    "country": '<?php echo $diferenciaTexto2 ?>'+': '+'<?php echo $incremento2 ?>',
    "year2004": <?php echo $incremento2?>
}];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "";
valueAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "year2004";
series.dataFields.categoryX = "country";
series.clustered = false; 
 
chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

var incremento2 = <?php echo $incremento2 ?>;
var t111= <?php echo $totalNoAsociado ?>;
var t222= <?php echo $totalNoAsociado2 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto2 ?>'+": "+incremento2;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": "+t111;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": "+t222;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "INGRESOS NO ASOCIADOS AL PARQUE";
title.fontSize = 25;
title.marginBottom = 30;
chart.exporting.menu = new am4core.ExportMenu();

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv">
</div>
<div id="chartdiv1">
</div>
<div id="chartdiv2">
</div>

</html>
