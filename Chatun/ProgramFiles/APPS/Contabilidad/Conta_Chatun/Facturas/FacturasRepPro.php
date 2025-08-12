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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">
		
		<?php
			$FechaInicio  = $_POST["FechaInicio"];
			$FechaFin     = $_POST["FechaFin"];
			$TipoFacturas = $_POST["TipoFacturas"];
			if($TipoFacturas == 2)
			{
				$Nombre = 'Operadas';
			}
			else
			{
				$Nombre = 'Rechazadas';
			}
		?>
		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="FacturasRepPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Reporte de Facturas <?php echo $TipoFacturas ?></strong></h4>
							</div>
							<div class="card-body">
							<?php

								$Consulta = "SELECT A.*, B.* 
											FROM Contabilidad.TRANSACCION AS A, Contabilidad.PROVEEDOR AS B 
											WHERE A.P_CODIGO = B.P_CODIGO 
											AND A.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
											AND A.TT_CODIGO = 2 
											AND E_CODIGO = ".$TipoFacturas;
								$Resultado = mysqli_query($db, $Consulta);
								$NumeroResultados = mysqli_num_rows($Resultado);
								if($NumeroResultados > 0)
								{
									?>
									<table class="table">
										<thead>
											<tr>
												<th>
													<h6><strong>Fecha</strong></h6>
												</th>
												<th>
													<h6><strong>Serie</strong></h6>
												</th>
												<th>
													<h6><strong>Factura</strong></h6>
												</th>
												<th>
													<h6><strong>Código Contable</strong></h6>
												</th>
												<th>
													<h6><strong>Proveedor</strong></h6>
												</th>
												<th>
													<h6><strong>Concepto</strong></h6>
												</th>
												<th>
													<h6><strong>Monto</strong></h6>
												</th>
											</tr>
										</thead>
										<tbody>
										<?php
											while($row = mysqli_fetch_array($Resultado))
											{
												echo '<tr>';
													echo '<td>'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</td>';
													echo '<td>'.$row["TRA_SERIE"].'</td>';
													echo '<td>'.$row["TRA_FACTURA"].'</td>';
													echo '<td>'.$row["P_CODIGO"].'</td>';
													echo '<td>'.$row["P_NOMBRE"].'</td>';
													echo '<td>'.$row["TRA_CONCEPTO"].'</td>';
													echo '<td>'.number_format($row["TRA_TOTAL"], 2, '.', ',').'</td>';
													echo '<td><a href="ConsFactura.php?Codigo='.$row["TRA_CODIGO"].'"><button type="button" class="btn btn-warning btn-xs">
														    <span class="glyphicon glyphicon-search"></span> Consultar
														  </button></a></td>';
												echo '</tr>';
											}
										?>
										</tbody>
									</table>
									<?php
								}
								else
								{
									?>
										<div class="alert alert-callout alert-success" role="alert">
											No existen facturas <?php echo $Nombre ?> en este rango de fechas.
										</div>
									<?php
								}
							?>
								
							</div>
						</div>
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
