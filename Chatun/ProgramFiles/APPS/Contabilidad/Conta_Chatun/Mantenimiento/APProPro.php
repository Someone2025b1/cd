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
		function Enviar()
		{
			// confirm dialog
			alertify.confirm("¿Estás seguro que deseas anular esta póliza?", function (e) {
			    if (e) {
			        $('#Formulario').submit();
			    }
			});
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>


	<?php
	$Consulta = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["Codigo"]."'";
		$Resultado = mysqli_query($db, $Consulta);
		while($row = mysqli_fetch_array($Resultado))
		{
		    $GLOBALS['Comprobante'] = $row["TRA_COMPROBANTE"];
		    $Fecha                  = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
		    $Hora                   = $row["TRA_HORA"];
		    $Concepto               = $row["TRA_CONCEPTO"];
		    $FechaHoy               = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
		    $Usuario                = $row["TRA_USUARIO"];
		    $Serie                  =$row["TRA_SERIE"];
		    $Factura                =$row["TRA_FACTURA"];
		    $TipoCompra             =$row["TC_CODIGO"];
		    $Combustible            = $row["COM_CODIGO"];
		    $DestinoCombustible     =$row["TRA_DESTINO_COM"];
		    $CantidadGalones        =$row["TRA_CANT_GALONES"];
		    $PrecioGalones          =$row["TRA_PRECIO_GALONES"];
		    $TotalFactura           =$row["TRA_TOTAL"];
		    $FormaPago              =$row["FP_CODIGO"];
		    $Usuario                =$row["TRA_USUARIO"];
		    $NoPoliza               =$row["TRA_CORRELATIVO"];
		    $Contabilizo            =$row["TRA_CONTABILIZO"];
		    $NoHoja					=$row["TRA_NO_HOJA"];
		    $FechaFact   			=$row["TRA_FECHA_TRANS"];
		    $Periodo 				=$row["PC_CODIGO"];

		}

	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="AnulacionPro.php" method="POST" role="form" id="Formulario">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Consulta de Póliza</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="CodigoPoliza" id="CodigoPoliza" value="<?php echo $NoPoliza; ?>" required readonly/>
											<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $_GET['Codigo']; ?>" required readonly/>
											<label for="CodigoPoliza">No. de Póliza</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Comprobante" id="Comprobante" value="<?php echo $NoHoja; ?>"  required readonly/>
											<label for="Comprobante">No. de Comprobante</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaFact; ?>" required readonly/>
											<label for="Fecha">Fecha</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" required readonly>
												<?php
													$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
													$ResultPeriodo = mysqli_query($db, $QueryPeriodo);
													while($FilaP = mysqli_fetch_array($ResultPeriodo))
													{
														if($FilaP["PC_CODIGO"] == $Periodo)
														{
															$Text = "selected";
														}
														else
														{
															$Text = "";
														}
														echo '<option value="'.$FilaP["PC_CODIGO"].'" '.$Text.'>'.$FilaP["PC_MES"]."-".$FilaP["PC_ANHO"].'</option>';
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
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" value="<?php echo $Concepto; ?>" required readonly/>
											<label for="Concepto">Concepto</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cuenta</strong></td>
                                                <td><strong>Cargos</strong></td>
                                                <td><strong>Abonos</strong></td>
                                                <td><strong>Razón</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
														FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
														WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO 
														AND TRA_CODIGO = '".$_GET["Codigo"]."'";
											$Resultado = mysqli_query($db, $Consulta);
											while($row = mysqli_fetch_array($Resultado))
											{
												?>
	                                            <tr>
	                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $row['N_CODIGO'].'/'.$row['N_NOMBRE']; ?>" readonly></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="<?php echo $row['TRAD_CARGO_CONTA']; ?>" min="0" readonly></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="<?php echo $row['TRAD_ABONO_CONTA']; ?>"  min="0" readonly></h6></td>
	                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]" value="<?php echo $row['TRAD_RAZON']; ?>" readonly></h6></td>
	                                            </tr>
											    <?php
											    $TotalCargos = $TotalCargos + $row["TRAD_CARGO_CONTA"];
											    $TotalAbonos = $TotalAbonos + $row["TRAD_ABONO_CONTA"];
											}
											?>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px" value="<?php echo $TotalCargos; ?>"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="<?php echo $TotalAbonos; ?>" ></h6></td>
                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="button" onclick="Enviar()" class="btn ink-reaction btn-raised btn-danger" id="btnGuardar">Anular</button>
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
