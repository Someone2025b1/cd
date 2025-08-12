<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
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

	<script>
	function SaberMesPeriodo(x){

		var service = $(x).val();
		var dataString = 'service='+service;
			
			//Le pasamos el valor del input al ajax
			$.ajax({
				type: "POST",
				url: "VerFechaConPeriodo.php",
				data: dataString,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				success: function(data) {  
							Periodo = data; 
						}
			});

			}
		

	</script>
	
<script>
	function IngresarPolizaSi(){

		var mesperiodo1 = Periodo;
		var mesperiodo2= new Date(mesperiodo1);
		var mesperiodo3 = mesperiodo2.getMonth();
		
		var mesfecha1 = document.getElementById('Fecha').value;
		var mesfecha2 = new Date(mesfecha1);
		var mesfecha3 = mesfecha2.getMonth();

		var mesfecha = mesfecha3+1;
		var mesperiodo = mesperiodo3+1;

		
		if(mesfecha!=mesperiodo){
		var respuesta = confirm("La Fecha no coincide con el Periodo Contable, ¿Quieres Correr la Poliza Aún?");

		if (respuesta== true){

			return true;

			}else{
				
				return false;
			}
		}
	}

		</script>

</head>	
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

		<?php

	$query = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION
				WHERE TT_CODIGO = 1";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		if($row["CORRELATIVO"] == 0)
		{
			$Correlativo = 1;
		}
		else
		{
			$Correlativo = $row["CORRELATIVO"] + 1;
		}
	}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="PDPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Depreciación de Activos Fijos (Compras)</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required/>
											<label for="Fecha">Fecha</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Comprobante" id="Comprobante" required/>
											<label for="Comprobante">Comprobante</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" onchange="SaberMesPeriodo(this)" required>
												<option value="" disabled selected>Seleccione</option>
												<?php
													$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
													$ResultPeriodo = mysqli_query($db,$QueryPeriodo);
													while($FilaP = mysqli_fetch_array($ResultPeriodo))
													{
														echo '<option value="'.$FilaP["PC_CODIGO"].'">'.$FilaP["PC_MES"]."-".$FilaP["PC_ANHO"].'</option>';
												}
												?>
											</select>
											<label for="Periodo">Periodo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" required/>
											<label for="Concepto">Concepto</label>
										</div>
									</div>	
								</div>
								<div class="col-lg-12 text-center">
									<button type="submit" class="btn btn-success btn-lg" onclick="return IngresarPolizaSi()">
										<span class="glyphicon glyphicon-check"></span> Correr Partida de Dereciación
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
