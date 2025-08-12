<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


function _data_last_month_day($Mes, $Anho) { 
    $month = $Mes;
    $year = $Anho;
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));

    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day($Mes, $Anho) {
    $month = $Mes;
    $year = $Anho;
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
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
	<!-- END META -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../../js/core/source/App.js"></script>
	<script src="../../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
            <form class="form" action="ComparativaDiario.php" method="POST" role="form" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Libro Diario</strong></h4>
							</div>
							<div class="card-body">
							<div class="row text-center">

            <?php


    $Filtro = "AND TRA_FECHA_TRANS BETWEEN '$_POST[FechaInicial]' AND '$_POST[FechaFinal]'";
    $FechaInicio = $_POST["FechaInicial"];
    $FechaFin = $_POST["FechaFinal"]; 
    $TextoFecha = "Del ".date('d-m-Y', strtotime($FechaInicio))." Al ".date('d-m-Y', strtotime($FechaFin));

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
  
$TotalCargos = 0;
$TotalAbonos = 0;

?>
<table class="table table-hover table-condensed" id="TblTicketsHotel">
    
    <thead> </thead>
    <tbody>

<?php

$Consulta1 = "SELECT TRANSACCION.*, TIPO_TRANSACCION.TT_NOMBRE FROM Contabilidad.TRANSACCION, Contabilidad.TIPO_TRANSACCION
            WHERE TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO 
            AND E_CODIGO = 2 AND TRA_ESTADO = 1
            $Filtro
            ORDER BY TRA_CORRELATIVO, TRA_FECHA_TRANS, TRA_HORA";

$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    $TotalCargos = 0;
    $TotalAbonos = 0;
$Codigo = $row1["TRA_CODIGO"];
$NoPartida = $row1["TRA_CORRELATIVO"]; 
$Concepto = $row1["TRA_CONCEPTO"]; 
$Transaccion = $row1["TT_NOMBRE"];
$Fecha = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"])); 




$Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
AND TRA_CODIGO = '".$Codigo."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{

$codTRa=$row["TRA_CODIGO"];
$Cargos = $row["TRAD_CARGO_CONTA"];
$Abonos2 = $row["TRAD_ABONO_CONTA"];



$TotalCargos = $TotalCargos + $Cargos;
$TotalAbonos = $TotalAbonos + $Abonos2;

$TotalGeneralCargos = $TotalGeneralCargos + $TotalCargos;
$TotalGeneralAbonos = $TotalGeneralAbonos + $TotalAbonos;
}

if ($TotalCargos!=$TotalAbonos){

    ?>
<tr>
    <td  colspan="4" align="left" style="background-color: #C9C9C9"><b><?php echo "# $NoPartida  $Transaccion del $Fecha" ?></b></td>
    </tr>
    <tr>
    <td  colspan="4" align="left" style="background-color: #C9C9C9"><b><?php echo $Concepto ?></b></td>
    </tr>

    <tr>
    <td align="left" style="background-color: #C9C9C9"><b>Código</b></td>
    <td align="left" style="background-color: #C9C9C9"><b>Cuenta</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Debe</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Haber</b></td>
    </tr>

    
<?php

    $Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
AND TRA_CODIGO = '".$codTRa."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{

$Codigo = $row["N_CODIGO"];
$Nombre = $row["N_NOMBRE"];
$Cargosimp = $row["TRAD_CARGO_CONTA"];
$Abonosimp = $row["TRAD_ABONO_CONTA"];
    

    ?>
    <td align="left"><?php echo $Codigo ?></td>
    <td align="left"><?php echo $Nombre ?></td>
    <td align="right"><?php echo $Cargosimp ?></td>
    <td align="right"><?php echo $Abonosimp ?></td>
    </tr>
    
    <?php
}
    $TotalCargos = number_format($TotalCargos, 3, ".", "");
$TotalAbonos = number_format($TotalAbonos, 3, ".", "");


?>
<tr>
<td align="left" style="background-color: red"></td>
<td align="left" style="background-color: red"><b>Sumas Iguales</b></td>
<td align="right" style="background-color: red"><b><?php echo $TotalCargos ?></b></td>
<td align="right" style="background-color: red"><b><?php echo $TotalAbonos ?></b></td>
</tr>


<tr>
<td align="left" colspan="4">______________________________________________________________________________________________</td>
</tr>




<?php
    
}




}
if($TotalGeneralAbonos!=$TotalGeneralCargos){

    $TotalGeneralCargos = number_format($TotalGeneralCargos, 3, '.', ',');
$TotalGeneralAbonos = number_format($TotalGeneralAbonos, 3, '.', ',');

?>
<tr>
<td align="left" style="background-color: red"></td>
<td align="left" style="background-color: red"><b>Total Cargos</b></td>
<td align="right" style="background-color: red"><b><?php echo $TotalGeneralCargos ?></b></td>
<td align="left" style="background-color: red"></td>

</tr>

<tr>
<td align="left" style="background-color: red"></td>
<td align="left" style="background-color: red"><b>Total Abonos</b></td>
<td align="right" style="background-color: red"><b><?php echo $TotalGeneralAbonos ?></b></td>
<td align="left" style="background-color: red"></td>
</tr>
<?php
    
}
?>


    </tbody>

</table>

                            </div>
                            </div>
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </div>
    <?php include("../MenuUsers.html"); ?>
</body>
</html>