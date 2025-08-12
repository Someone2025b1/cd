<?php 
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];





/*TITULOS*/
    
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

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
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">
    <div id="content">
			<div class="container">
				<form class="form" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
                        <div class="card-head style-primary">
								<h4 class="text-center"><strong>Estado de Cuenta</strong></h4>
							</div>
                            <br>
                            <br>
<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
    
<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
        
		    </thead>
		    <tbody> 
            <tr>
            <td align="center" colspan="6" ><b>Asociación para el Crecimiento Educativo Reg.
Cooperativo y Apoyo Turístico de Esquipulas
-ACERCATE-</b></td>
          </tr>
        <tr>
			<td><b>Fecha</b></td>
			<td><b>Factura</b></td>
			<td><b>Tipo</b></td>
            <td><b>Concepto</b></td>
			<td><b>Cargos</b></td>
            <td><b>Abonos</b></td>
            <td><b>Total</b></td>
        </tr>
<?php
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$Codigo = $_POST["NombreCuenta"];
$Nombre = $_POST["CodigoCuenta"];

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Producto = $_POST["Producto"];


$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;
    /*FIN TITULOS*/
    $QueryAnterior = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TRA_FECHA_TRANS
                    BETWEEN  '2016/01/01'
                    AND  '".$FechaFinal."'
                    AND TRANSACCION_DETALLE.N_CODIGO =  '".$Nombre."'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1";
$ResultAnterior = mysqli_query($db, $QueryAnterior);
while($FilaAnterior = mysqli_fetch_array($ResultAnterior))
{
if($Nombre[0] == 1)
{
$Saldo = $FilaAnterior["CARGOS"] - $FilaAnterior["ABONOS"];    
}
else
{
$Saldo = $FilaAnterior["ABONOS"] - $FilaAnterior["CARGOS"];
}

$SaldoFinal = $SaldoFinal + $Saldo;

    ?>
    <tr>
			<td><b>-----</b></td>
			<td><b>-----</b></td>
			<td><b>-----</b></td>
            <td><b>Saldos Anteriores</b></td>
			<td><b><?php echo number_format($FilaAnterior["CARGOS"], 2, '.', ','); ?></b></td>
            <td><b><?php echo number_format($FilaAnterior["ABONOS"], 2, '.', ','); ?></b></td>
            <td><b><?php echo number_format($SaldoFinal, 2, '.', ','); ?></b></td>
        </tr>
    <?php

}

$QueryAnterior = "SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA AS CARGOS, TRANSACCION_DETALLE.TRAD_ABONO_CONTA AS ABONOS, TIPO_TRANSACCION.TT_NOMBRE, TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_SERIE, TRANSACCION.TRA_FACTURA
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TIPO_TRANSACCION, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
                    AND (TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."')
                    AND TRANSACCION_DETALLE.N_CODIGO = '".$Nombre."'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
                    ORDER BY TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_HORA";
$ResultAnterior = mysqli_query($db, $QueryAnterior);
while($FilaAnterior = mysqli_fetch_array($ResultAnterior))
{
    if($Nombre[0] == 1)
    {
        $Saldo = $FilaAnterior["CARGOS"] - $FilaAnterior["ABONOS"];    
    }
    else
    {
        $Saldo = $FilaAnterior["ABONOS"] - $FilaAnterior["CARGOS"];
    }

    $SaldoFinal = $SaldoFinal + $Saldo;

    ?>
    <tr>
			<td><b><?php echo date('d-m-Y', strtotime($FilaAnterior["TRA_FECHA_TRANS"])); ?></b></td>
			<td><b><?php echo $FilaAnterior["TRA_SERIE"].'-'.$FilaAnterior["TRA_FACTURA"]; ?></b></td>
			<td><b><?php echo $FilaAnterior["TT_NOMBRE"]; ?></b></td>
            <td><b><?php echo $FilaAnterior["TRA_CONCEPTO"]; ?></b></td>
			<td><b><?php echo number_format($FilaAnterior["CARGOS"], 2, '.', ','); ?></b></td>
            <td><b><?php echo number_format($FilaAnterior["ABONOS"], 2, '.', ','); ?></b></td>
            <td><b><?php echo number_format($SaldoFinal, 2, '.', ','); ?></b></td>
        </tr>
    <?php

    
}


?>
</div>
					</div>
					<br>
					<br>
				</form>
			</div>
</div>
    </div>
    
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>
</body>
<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>	
	</html>