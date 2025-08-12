<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$UserID = $_SESSION["iduser"];
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
				<form class="form" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Contabilización Depreciación de Activos Fijos (Compras)</strong></h4>
							</div>
							<div class="card-body">
							<?php
								$UI           = uniqid('tra_');
								$UID          = uniqid('trad_');
								$Contador     = count($_POST["Cuenta"]);
								$Centinela    = true;

								$Fecha        = $_POST["Fecha"];
								$Concepto     = $_POST["Concepto"];
								$Periodo      = $_POST["Periodo"];
								$Comprobante  = $_POST["Comprobante"];
								$TotalPoliza  = 0;
								
								$Cuenta       = $_POST["Cuenta"];
								$Cargos       = $_POST["Cargos"];
								$Abonos       = $_POST["Abonos"];

								for($i=1; $i<$Contador; $i++)
                        		{
                        			$TotalPoliza  = $TotalPoliza + $Cargos[$i];
                        		}

                        		$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE PC_CODIGO = ".$Periodo;
										$resultCorrelativo = mysqli_query($db,$queryCorrelativo);
										while($rowCor = mysqli_fetch_array($resultCorrelativo))
										{	
											if($rowCor["CORRELATIVO"] == 0)
											{
												$Correlativo = 1;
											}
											else
											{
												$Correlativo = $rowCor["CORRELATIVO"] + 1;
											}
										}

								$sql = mysqli_query($db,"INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_NO_HOJA, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_CORRELATIVO, TRA_TOTAL, PC_CODIGO, TRA_CONTABILIZO)
													VALUES('".$UI."', '".$Comprobante."', '".$Fecha."', '".$Concepto."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 2, 16, '".$Correlativo."', ".$TotalPoliza.", ".$Periodo.", '".$UserID ."')");
									
								if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
								{

									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar la póliza.</h2>
											<h4 class="text-light">Código de transacción: '.$UI.'</h4>
										</div>';
									echo mysqli_error($db, $sql);
									$Centinela = false;
									
								}
								else
								{
									for($i=0; $i<$Contador; $i++)
                        			{
										$Cue = $Cuenta[$i];
										$Car = $Cargos[$i];
										$Abo = $Abonos[$i];

										$Xplotado = explode("/", $Cue);
										$NCue = $Xplotado[0];

										$query = mysqli_query($db,"INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
															VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.")");

										if(!$query)
										{
											echo '<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
													<h2 class="text-light">Lo sentimos, no se pudo ingresar la póliza.</h2>
													<h4 class="text-light">Código de transacción: '.$UID.'</h4>
												</div>';
											echo mysqli_error($db, $query);
											$Centinela = false;
											
										}	
									}	

									if($Centinela == true)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">La póliza se ingresó correctamente.</h2>
											<div class="row">
												<div class="col-lg-6 text-right"><a href="IngresoImp.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
												<div class="col-lg-6 text-left"><a href="Ingreso.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';

										echo '<input type="hidden" id="CodigoPolizaUI" value="'.$UI.'" />';

										echo "<script>";
										echo "redireccionar();";
										echo "</script>";
									}						
								}


								$Query = "SELECT AF_AREA FROM Contabilidad.ACTIVO_FIJO GROUP BY AF_AREA ORDER BY AF_AREA";
								$Consulta = mysqli_query($db,$Query);
								while($row = mysqli_fetch_array($Consulta))
								{
									$Area = $row["AF_AREA"];

									$QueryA = "SELECT ACTIVO_FIJO.*, TIPO_ACTIVO.TA_DEPRECIACION 
									FROM Contabilidad.ACTIVO_FIJO, Contabilidad.TIPO_ACTIVO 
									WHERE ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
									AND ACTIVO_FIJO.AF_AREA = ".$Area." 
									AND ACTIVO_FIJO.AF_DONACION = 0
									ORDER BY ACTIVO_FIJO.AF_CODIGO";
									$ResultA = mysqli_query($db,$QueryA);

									while($row2 = mysqli_fetch_array($ResultA))
									{
										$MesActivo = date('m', strtotime($row2["AF_FECHA_ADQUISICION"]));

										#if($Mes > $MesActivo)
										#{
											if($row2["TA_CODIGO"] == 1)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 2)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 3)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 4)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 5)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 6)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 7)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
											elseif($row2["TA_CODIGO"] == 8)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR_ACTUAL"];
													$ValorReal = $row2["AF_VALOR"];
													
												$CodigoActivo = $row2["AF_CODIGO"];

													$TotalDepreciacionME = (($ValorReal-1) * ($Depreciacion / 100)) / 12;

													$ValorActualizado = $ValorActual - $TotalDepreciacionME;
													
													$ActualizarValor = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = ".$ValorActualizado." WHERE AF_CODIGO = '".$CodigoActivo."'");
												}
											}
										}			
									}
								#}

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

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
