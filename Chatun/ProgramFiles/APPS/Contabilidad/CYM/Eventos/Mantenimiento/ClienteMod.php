<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Codigo = $_GET["Codigo"];

$Consulta = "SELECT * FROM Bodega.CLIENTE_EVENTO AS A WHERE A.CE_CODIGO = '".$Codigo."'";
	$Resultado = mysqli_query($db, $Consulta) or die (mysqli_error());
	while($row = mysqli_fetch_array($Resultado))
	{
		$CUI       = $row["CE_CUI"];
		$NIT       = $row["CE_NIT"];
		$Nombre    = $row["CE_NOMBRE"];
		$Direccion = $row["CE_DIRECCION"];
		$Celular   = $row["CE_CELULAR"];
		$Telefono  = $row["CE_TELEFONO"];
		$Email     = $row["CE_EMAIL"];
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

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		margin-left:5px;
    		margin-top:5px;
    		width:350px;
    		cursor:pointer;
    	}
    	#suggestions {
    		width:auto;
    		height:auto;
    		overflow: auto;
    	}
    </style>

	<script>
		$(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>


	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Clientes Eventos</strong><br></h1>
				<br>
				<form class="form" action="ClienteModPro.php" method="POST" role="form">
					<input type="hidden" name="Codigo" value="<?php echo $_GET["Codigo"] ?>">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Cliente</strong></h4>
							</div>
							<div class="card-body">
								<div class="col-lg-12">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<label>CUI</label>
											<input type="text" class="form-control" name="CUI" id="CUI" value="<?php echo $CUI ?>" required readonly>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<label>NIT</label>
											<input type="text" class="form-control" name="NIT" id="NIT" value="<?php echo $NIT ?>" required readonly>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="col-lg-6">
										<div class="form-group  floating-label">
											<label>Nombre</label>
											<input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="col-lg-12">
										<div class="form-group  floating-label">
											<label>Dirección</label>
											<input type="text" class="form-control" name="Direccion" id="Direccion" value="<?php echo $Direccion ?>" required>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="col-lg-3">
										<div class="form-group  floating-label">
											<label>Celular</label>
											<input type="number" class="form-control" name="Celular" id="Celular" value="<?php echo $Celular ?>" required>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group  floating-label">
											<label>Teléfono</label>
											<input type="number" class="form-control" name="Telefono" id="Telefono" value="<?php echo $Telefono ?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group  floating-label">
											<label>Email</label>
											<input type="email" class="form-control" name="Email" id="Email" value="<?php echo $Email ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
