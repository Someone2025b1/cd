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
 $filtroAsociados = "DATE(a.CH_Fecha) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 
}
elseif($dia!="")
{
 $texto = fecha_con_mes($dia);
 $filtroAsociados = "DATE(a.CH_Fecha) = '$dia'";
  
}
elseif($anio!="")
{
 $texto = $anio;
 $filtroAsociados = "YEAR(DATE(a.CH_Fecha)) = '$anio'";
 
}
elseif($mesObtenido!="")
{
 $texto = $mes."-".$year;
 $filtroAsociados = "MONTH(DATE(a.CH_Fecha)) = '$mes' and YEAR(DATE(a.CH_Fecha)) = $year";
  
}
 
$Query = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(b.DC_TotalAdulto) ADULTOS, SUM(b.DC_TotalNino) AS NINO FROM Taquilla.CORTE_HOTEL a INNER JOIN Taquilla.DETALLE_CORTE b ON a.CH_Id = b.CH_Id INNER JOIN Taquilla.HOTEL c ON c.H_CODIGO = b.H_CODIGO where $filtroAsociados"));

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
 $filtroAsociados2 = "DATE(a.CH_Fecha) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
 $filtroNoA2 = "DATE(a.INA_FECHA_INGRESO) BETWEEN  '$fechaInicial2' AND '$fechaFinal2'";
  
}
elseif($dia2!="")
{
 $texto2 = fecha_con_mes($dia2);
 $filtroAsociados2 = "DATE(a.CH_Fecha) = '$dia2'";
 
}
elseif($anio2!="")
{
 $texto2 = $anio2;
 $filtroAsociados2 = "YEAR(DATE(a.CH_Fecha)) = '$anio2'";
  
}
elseif($mesObtenido2!="")
{
 $texto2 = $mes2."-".$year2;
 $filtroAsociados2 = "MONTH(DATE(a.CH_Fecha)) = '$mes2' and YEAR(DATE(a.CH_Fecha)) = $year2";
  
} 


$Query2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(b.DC_TotalAdulto) ADULTOS, SUM(b.DC_TotalNino) AS NINO FROM Taquilla.CORTE_HOTEL a INNER JOIN Taquilla.DETALLE_CORTE b ON a.CH_Id = b.CH_Id INNER JOIN Taquilla.HOTEL c ON c.H_CODIGO = b.H_CODIGO where $filtroAsociados2"));

$totalAdulto = $Query["ADULTOS"];
$totalAdulto1 = $Query2["ADULTOS"];

if ($totalAdulto!="") {
  $totalAdulto = $Query["ADULTOS"];
}
else
{
  $totalAdulto = 0;
}
if ($totalAdulto1!="") {
  $totalAdulto1 = $Query2["ADULTOS"];
}
else
{
  $totalAdulto1 = 0;
}
$totalNinos = $Query["NINO"];
$totalNinos1 = $Query2["NINO"];

if ($totalNinos!="") {
  $totalNinos = $Query["NINO"];
}
else
{
  $totalNinos = 0;
}
if ($totalNinos1!="") {
  $totalNinos1 = $Query2["NINO"];
}
else
{
  $totalNinos1 = 0;
}

$incremento = number_format($totalAdulto1 - $totalAdulto,2);
$incremento1 = number_format($totalNinos1 - $totalNinos,2);

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
  "country": '<?php echo $texto?>'+': Q. '+'<?php echo $totalAdulto ?>',
  "visits": <?php echo $totalAdulto?>
}, {
  "country": '<?php echo $texto2?>'+': Q. '+'<?php echo $totalAdulto1 ?>',
  "visits": <?php echo $totalAdulto1?>
}, {
  "country": '<?php echo $diferenciaTexto?>'+': Q. '+'<?php echo $incremento ?>',
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
var t1= <?php echo $totalAdulto ?>;
var t2= <?php echo $totalAdulto1 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto?> : Q. '+incremento;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": Q. "+t1;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": Q. "+t2;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "VENTAS ADULTOS";
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
  "year": '<?php echo $texto?>'+': Q. '+'<?php echo $totalNinos ?>',
  "income": <?php echo $totalNinos?>
}, {
  "year": '<?php echo $texto2?>'+': Q. '+'<?php echo $totalNinos1 ?>',
  "income": <?php echo $totalNinos1?>
}, {
  "year": '<?php echo $diferenciaTexto1 ?>'+': Q. '+'<?php echo $incremento1 ?>',
  "income": <?php echo $incremento1?>
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
var t11= <?php echo $totalNinos ?>;
var t22= <?php echo $totalNinos1 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto1?>'+": Q. "+incremento1;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": Q. "+t11;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": Q. "+t22;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "VENTAS NIÑOS";
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
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [{
  "country": '<?php echo $texto?>'+': Q. '+'<?php echo $totalAdulto+$totalNinos ?>',
  "visits": <?php echo $totalAdulto+$totalNinos?>
}, {
  "country": '<?php echo $texto2?>'+': Q. '+'<?php echo $totalAdulto1+$totalNinos1 ?>',
  "visits": <?php echo $totalAdulto1+$totalNinos1?>
}, {
  "country": '<?php echo $diferenciaTexto?>'+': Q. '+'<?php echo $incremento+$incremento1 ?>',
  "visits": <?php echo $incremento+$incremento1?>
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
var incremento = <?php echo $incremento+$incremento1 ?>;
var t1= <?php echo $totalAdulto+$totalNinos ?>;
var t2= <?php echo $totalAdulto1+$totalNinos1 ?>; 

var title2 = chart.titles.create();
title2.text = '<?php echo $diferenciaTexto?> : Q. '+incremento;
title2.fontSize = 18; 
title2.align = "left";
var title1 = chart.titles.create();
title1.text = '<?php echo $texto?>'+": Q. "+t1;
title1.fontSize = 18; 
title1.align = "left";
var title = chart.titles.create();
title.text = '<?php echo $texto2?>'+": Q. "+t2;
title.fontSize = 18;
title.align = "left";
var title = chart.titles.create();
title.text = "VENTAS TOTALES";
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
