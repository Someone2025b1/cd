<?php
error_reporting(error_reporting() & ~E_NOTICE);
	$db = mysqli_connect("10.60.58.214", "root","chatun2021");
	if (!$db) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
	$db1 = mysqli_connect("10.60.58.214", "root","chatun2021");
//defino tipo de caracteres a manejar.
	mysqli_set_charset($db, 'utf8');
//defino variables globales de las tablas
	$base_asociados = 'info_asociados';
	$base_general = 'info_base';
	$base_bbdd = 'info_bbdd';
	$base_colaboradores = 'info_colaboradores';
?>

<?php
include("../../../../../Script/seguridad.php");
// include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$Usuar = $_SESSION["iduser"];
// 1801788
// $Usuar==53711 | $Usuar==22045 | $Usuar==435849
if($Usuar==1801788){
	$Filtro="";
}else{
	$Filtro="AND CC_REALIZO ="."$Usuar";
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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	 <div id="base">
    <div id="content">
        <div class="container">
            <h1 class="text-center"><strong>Consulta de Cuentas Por Pagar</strong><br></h1>
            <br>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Deuda por Proveedor</strong></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-condensed" id="tbl_proveedores">
                            <thead>
                                <th><strong>No.</strong></th>
                                <th><strong>Código Proveedor</strong></th>
                                <th><strong>Nombre Proveedor</strong></th>
                                <th><strong>Total Deuda</strong></th>
                                <th><strong>Facturas Pendientes</strong></th>
                                <th><strong>Pagar / Abonar</strong></th>
                            </thead>
                            <tbody>
                            <?php
                            $contador = 1;
                            // Consulta adaptada a tu estructura de tablas
                            $consulta = "SELECT
                                            P.P_CODIGO,
                                            P.P_NOMBRE,
                                            COUNT(CP.CP_CODIGO) AS FacturasPendientes,
                                            SUM(CP.CP_TOTAL - CP.CP_ABONO) AS TotalDeuda
                                        FROM
                                            Contabilidad.CUENTAS_POR_PAGAR AS CP
                                        JOIN
                                            Contabilidad.PROVEEDOR AS P ON CP.N_CODIGO = P.P_CODIGO
                                        WHERE
                                            CP.CP_ESTADO = 1 -- 1=Pendiente
                                        GROUP BY
                                            P.P_CODIGO, P.P_NOMBRE
                                        HAVING
                                            TotalDeuda > 0
                                        ORDER BY
                                            P.P_NOMBRE ASC";
 
                            $resultado = mysqli_query($db, $consulta);
                            while($row = mysqli_fetch_array($resultado)) {
                                $codigoProveedor = $row["P_CODIGO"];
                                echo '<tr>';
                                echo '<td>'.$contador.'</td>';
                                echo '<td>'.$row["P_CODIGO"].'</td>';
                                echo '<td>'.$row["P_NOMBRE"].'</td>';
                                echo '<td>Q. '.number_format($row["TotalDeuda"], 2).'</td>';
                                echo '<td class="text-center">'.$row["FacturasPendientes"].'</td>';
                                echo '<td class="text-center">
                                        <a href="RegistrarPagoProveedor.php?codigo='.$codigoProveedor.'" class="btn btn-info btn-xs">
                                            <span class="fa fa-money"></span> Pagar
                                        </a>
                                      </td>';
                                echo '</tr>';
                                $contador++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../MenuUsers2.html"); ?>
</div>
	<!--end #base-->
		<!-- END BASE -->

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
		<!-- END JAVASCRIPT -->

	</body>
	</html>