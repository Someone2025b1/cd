<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];

//obtener variables
$NombreNoAsociado = $_POST["NombreNoAsociado"];
$PaisNoAsociado = $_POST["PaisNoAsociado"];
if($PaisNoAsociado == 73) //si el pais es guatemala realizo POST 
	{
		$DepartamentoNoAsociado = $_POST["DepartamentoNoAsociado"];	
		$MunicipioNoAsociado = $_POST["MunicipioNoAsociado"];
	}

if($PaisNoAsociado == 54)// Si el pais es EL Salvador
	{
		$DepartamentoNoAsociado = $_POST["DepartamentosSalvador"];
		$MunicipioNoAsociado = 0;
	}
if($PaisNoAsociado == 79)//Si el pais es honduras
	{
		$DepartamentoNoAsociado = $_POST["DepartamentosHonduras"];
		$MunicipioNoAsociado = 0;
	}
		
$SelectVisitaEsquipulas = $_POST["SelectVisitaEsquipulas"];
$EnteradoNoAsociado = $_POST["EnteradoNoAsociado"];
$EdadNoAsociado = $_POST["EdadNoAsociado"];
if($EdadNoAsociado == "")
 	{
 		$EdadNoAsociado = 0;
 	}
$SelectAsisteconNoAsociado = $_POST["SelectAsisteconNoAsociado"];
$FrecuenciaVisitaNoAsociado = $_POST["FrecuenciaVisitaNoAsociado"];
$CorreoNoAsociado = $_POST["CorreoNoAsociado"];
$SelectConociaParque = $_POST["SelectConociaParque"];
$BuscaNoAsociado = $_POST["BuscaNoAsociado"];
$Cantidad = $_POST['Cantidad'];
$NumeroTelefonoNoAsociado = $_POST['NumeroTelefonoNoAsociado']; 
$trozos = explode(", ", $PaisNoAsociado);
$municipio= $trozos[0];
$depto =  $trozos[1];

 
$GuardarNoAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO VALUES (NULL, '$NombreNoAsociado', 73, $depto, $municipio, $SelectVisitaEsquipulas, $EnteradoNoAsociado, $EdadNoAsociado, $SelectAsisteconNoAsociado, $FrecuenciaVisitaNoAsociado, '$CorreoNoAsociado', '$NumeroTelefonoNoAsociado', $SelectConociaParque, $BuscaNoAsociado, $id_user, CURDATE(), $Cantidad[0], $Cantidad[1], $Cantidad[2]) ") or die("Error en guardar No Asociado".mysqli_error());
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
	
	<script>
		function EnviarFormulario()
		{
			var formulario = document.getElementById("FormularioEnviar");
			formulario.submit();
			return true;
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Consulta de Hoteles</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Hoteles</strong></h4>
						</div>
						<div class="card-body">
							<?php 
								$CodigoProducto = $_POST["CodigoProducto"];
								$Cantidad = $_POST["Cantidad"];
								$Precio = $_POST["Precio"];
								$SubTotal = $_POST["SubTotal"];
								$Contador = count($SubTotal);

								?>

								<form id="FormularioEnviar" action="../Facturacion/Vta.php" method="POST">
								<?php
									for($i=0; $i<$Contador; $i++)
									{
										?>
										<input class="form-control" type="number" name="CodigoProducto[]" id="CodigoProducto[]" value="<?php echo $CodigoProducto[$i]; ?>"/>
										<input class="form-control" type="number" name="Cantidad[]" id="Cantidad[]" value="<?php echo $Cantidad[$i]; ?>"/>
										<input class="form-control" type="number" name="Valor[]" id="Valor[]" value="<?php echo $Precio[$i]; ?>"/>
										<input class="form-control" type="number" name="Total[]" id="Total[]" value="<?php echo $SubTotal[$i]; ?>"/>
										<?php
									}
								?>
								</form>

								<script>
									EnviarFormulario();
								</script>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

		</div><!--end #base-->
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
