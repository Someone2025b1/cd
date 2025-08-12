<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$UserID = $_SESSION["iduser"];
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
		function Calcular()
		{
			var TotalCargos = 0;
			var TotalAbonos = 0;
			var Contador = document.getElementsByName('Cargos[]');
			var Cargos = document.getElementsByName('Cargos[]');
			var Abonos = document.getElementsByName('Abonos[]');

			for(i=0; i<Contador.length; i++)
			{
				TotalCargos = parseFloat(TotalCargos) + parseFloat(Cargos[i].value);
				TotalAbonos = parseFloat(TotalAbonos) + parseFloat(Abonos[i].value);
			}
			
			$('#TotalCargos').val(TotalCargos.toFixed(2));
			$('#TotalAbonos').val(TotalAbonos.toFixed(2));

			if(TotalCargos.toFixed(2) == TotalAbonos.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
				$('#btnGuardar').prop("disabled", false);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
				$('#btnGuardar').prop("disabled", true);
			}
		}
	</script>

</head>	
<body class="menubar-hoverable header-fixed menubar-pin " onload="Calcular()">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="PDProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Depreciación de Activos Fijos (Compras)</strong></h4>
							</div>
							<div class="card-body">
								<?php
								$UI           = uniqid();
								$Centinela    = true;

								$Fecha        = $_POST["Fecha"];
								$Concepto     = $_POST["Concepto"];
								$Periodo      = $_POST["Periodo"];

								$MesPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE PC_CODIGO = ".$Periodo;
								$ResultMes = mysqli_query($db,$MesPeriodo);
								$FilaMes = mysqli_fetch_array($ResultMes);

								$Mes = $FilaMes["PC_MES"];

								$QueryBorrado = mysqli_query($db,"TRUNCATE TABLE Contabilidad.DEPRECIACION_TEMPORAL");

								//Obtener todas las áreas donde se hayan activos fijos
								$Query = "SELECT AF_AREA FROM Contabilidad.ACTIVO_FIJO GROUP BY AF_AREA ORDER BY AF_AREA";
								$Consulta = mysqli_query($db,$Query);
								while($row = mysqli_fetch_array($Consulta))
								{
									$Area = $row["AF_AREA"];
									$SumaTotalDepreciacionME = 0;
									$SumaTotalDepreciacionEC = 0;
									$SumaTotalDepreciacionV = 0;
									$SumaTotalDepreciacionH = 0;
									$SumaTotalDepreciacionSI = 0;
									$SumaTotalDepreciacionSemo = 0;
									$SumaTotalDepreciacionEF = 0;
									$SumaTotalDepreciacionGI = 0;


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

										if($row2["AF_DEDUCIBLE"] == 1){

										//if($Mes > $MesActivo)
										//{
											if($row2["TA_CODIGO"] == 1)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionME = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionME = $SumaTotalDepreciacionME + $TotalDepreciacionME;
												}
											}
											elseif($row2["TA_CODIGO"] == 2)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionEC = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionEC = $SumaTotalDepreciacionEC + $TotalDepreciacionEC;
												}
											}
											elseif($row2["TA_CODIGO"] == 3)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionV = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionV = $SumaTotalDepreciacionV + $TotalDepreciacionV;
												}
											}
											elseif($row2["TA_CODIGO"] == 4)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionH = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionH = $SumaTotalDepreciacionH + $TotalDepreciacionH;
												}
											}
											elseif($row2["TA_CODIGO"] == 5)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionSI = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionSI = $SumaTotalDepreciacionSI + $TotalDepreciacionSI;
												}
											}
											elseif($row2["TA_CODIGO"] == 6)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionSemo = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionSemo = $SumaTotalDepreciacionSemo + $TotalDepreciacionSemo;
												}
											}
											elseif($row2["TA_CODIGO"] == 7)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionEF = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionEF = $SumaTotalDepreciacionEF + $TotalDepreciacionEF;
												}
											}
											elseif($row2["TA_CODIGO"] == 8)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionGI = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionGI = $SumaTotalDepreciacionGI + $TotalDepreciacionGI;
												}
											}
										}
										//}			
									}


									if($SumaTotalDepreciacionME != 0)
									{
										$SQLTemporalME = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 1, ".$SumaTotalDepreciacionME.", 1)");
									}

									if($SumaTotalDepreciacionEC != 0)
									{
										$SQLTemporalEC = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 2, ".$SumaTotalDepreciacionEC.", 1)");
									}

									if($SumaTotalDepreciacionV != 0)
									{
										$SQLTemporalV  = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 3, ".$SumaTotalDepreciacionV.", 1)");
									}

									if($SumaTotalDepreciacionH != 0)
									{
										$SQLTemporalH  = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 4, ".$SumaTotalDepreciacionH.", 1)");
									}

									if($SumaTotalDepreciacionSI != 0)
									{
										$SQLTemporalSI = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 5, ".$SumaTotalDepreciacionSI.", 1)");
									}
									if($SumaTotalDepreciacionSemo != 0)
									{
										$SQLTemporalSemo = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 6, ".$SumaTotalDepreciacionSemo.", 1)");
									}
									if($SumaTotalDepreciacionEF != 0)
									{
										$SQLTemporalEF = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 7, ".$SumaTotalDepreciacionEF.", 1)");
									}
									if($SumaTotalDepreciacionGI != 0)
									{
										$SQLTemporalGI = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 8, ".$SumaTotalDepreciacionGI.", 1)");
									}
									
								}


								###### NO DEDUCIBLES

								//Obtener todas las áreas donde se hayan activos fijos
								$Query = "SELECT AF_AREA FROM Contabilidad.ACTIVO_FIJO GROUP BY AF_AREA ORDER BY AF_AREA";
								$Consulta = mysqli_query($db,$Query);
								while($row = mysqli_fetch_array($Consulta))
								{
									$Area = $row["AF_AREA"];
									$SumaTotalDepreciacionME = 0;
									$SumaTotalDepreciacionEC = 0;
									$SumaTotalDepreciacionV = 0;
									$SumaTotalDepreciacionH = 0;
									$SumaTotalDepreciacionSI = 0;
									$SumaTotalDepreciacionSemo = 0;
									$SumaTotalDepreciacionEF = 0;
									$SumaTotalDepreciacionGI = 0;


									$QueryA = "SELECT ACTIVO_FIJO.*, TIPO_ACTIVO.TA_DEPRECIACION 
									FROM Contabilidad.ACTIVO_FIJO, Contabilidad.TIPO_ACTIVO 
									WHERE ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
									AND ACTIVO_FIJO.AF_AREA = ".$Area."
									AND ACTIVO_FIJO.AF_DEDUCIBLE = 0
									AND ACTIVO_FIJO.AF_DONACION = 0
									ORDER BY ACTIVO_FIJO.AF_CODIGO";
									$ResultA = mysqli_query($db,$QueryA);

									while($row2 = mysqli_fetch_array($ResultA))
									{
										$MesActivo = date('m', strtotime($row2["AF_FECHA_ADQUISICION"]));

										//if($Mes > $MesActivo)
										//{
											if($row2["TA_CODIGO"] == 1)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionME = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionME = $SumaTotalDepreciacionME + $TotalDepreciacionME;
												}
											}
											elseif($row2["TA_CODIGO"] == 2)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionEC = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionEC = $SumaTotalDepreciacionEC + $TotalDepreciacionEC;
												}
											}
											elseif($row2["TA_CODIGO"] == 3)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionV = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionV = $SumaTotalDepreciacionV + $TotalDepreciacionV;
												}
											}
											elseif($row2["TA_CODIGO"] == 4)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionH = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionH = $SumaTotalDepreciacionH + $TotalDepreciacionH;
												}
											}
											elseif($row2["TA_CODIGO"] == 5)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionSI = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionSI = $SumaTotalDepreciacionSI + $TotalDepreciacionSI;
												}
											}
											elseif($row2["TA_CODIGO"] == 6)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionSemo = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionSemo = $SumaTotalDepreciacionSemo + $TotalDepreciacionSemo;
												}
											}
											elseif($row2["TA_CODIGO"] == 7)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionEF = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionEF = $SumaTotalDepreciacionEF + $TotalDepreciacionEF;
												}
											}
											elseif($row2["TA_CODIGO"] == 8)
											{
												if(($row2["AF_VALOR_ACTUAL"] != 1) && ($row2["AF_ESTADO"] == 1))
												{
													$Depreciacion = $row2["TA_DEPRECIACION"];
													$ValorActual = $row2["AF_VALOR"];

													$TotalDepreciacionGI = (($ValorActual-1) * ($Depreciacion / 100)) / 12;
													$SumaTotalDepreciacionGI = $SumaTotalDepreciacionGI + $TotalDepreciacionGI;
												}
											}
										//}			
									}


									if($SumaTotalDepreciacionME != 0)
									{
										$SQLTemporalME = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 1, ".$SumaTotalDepreciacionME.", 0)");
									}

									if($SumaTotalDepreciacionEC != 0)
									{
										$SQLTemporalEC = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 2, ".$SumaTotalDepreciacionEC.", 0)");
									}

									if($SumaTotalDepreciacionV != 0)
									{
										$SQLTemporalV  = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 3, ".$SumaTotalDepreciacionV.", 0)");
									}

									if($SumaTotalDepreciacionH != 0)
									{
										$SQLTemporalH  = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 4, ".$SumaTotalDepreciacionH.", 0)");
									}

									if($SumaTotalDepreciacionSI != 0)
									{
										$SQLTemporalSI = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 5, ".$SumaTotalDepreciacionSI.", 0)");
									}
									if($SumaTotalDepreciacionSemo != 0)
									{
										$SQLTemporalSemo = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 6, ".$SumaTotalDepreciacionSemo.", 0)");
									}
									if($SumaTotalDepreciacionEF != 0)
									{
										$SQLTemporalEF = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 7, ".$SumaTotalDepreciacionEF.", 0)");
									}
									if($SumaTotalDepreciacionGI != 0)
									{
										$SQLTemporalGI = mysqli_query($db,"INSERT INTO Contabilidad.DEPRECIACION_TEMPORAL (DT_CODIGO, DT_AREA, DT_TIPO, DT_TOTAL, DT_DEDUCIBLE)
																	VALUES ('".$UI."', ".$Area.", 8, ".$SumaTotalDepreciacionGI.", 0)");
									}
									
								}

								?>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $_POST["Fecha"]; ?>" readonly required/>
											<label for="Fecha">Fecha</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Comprobante" id="Comprobante" value="<?php echo $_POST["Comprobante"]; ?>" required/>
											<label for="Comprobante">Comprobante</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" required>
												<?php
													$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE PC_CODIGO = ".$_POST["Periodo"];
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
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" value="<?php echo $_POST["Concepto"]; ?>" required/>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php

                                        		//Query Para traer datos por area
                                        		$QueryArea = "SELECT DT_AREA FROM Contabilidad.DEPRECIACION_TEMPORAL GROUP BY DT_AREA";
                                        		$ResultArea = mysqli_query($db,$QueryArea);
                                        		while($FilaArea = mysqli_fetch_array($ResultArea))
                                        		{
                                        			$DatoArea = $FilaArea["DT_AREA"];
                                        			//Query para traer datos por tipo
                                        			$QueryTipo = "SELECT DT_TIPO FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_AREA = ".$DatoArea." GROUP BY DT_TIPO";
                                        			$ResultTipo = mysqli_query($db,$QueryTipo);
                                        			while($FilaTipo = mysqli_fetch_array($ResultTipo))
                                        			{
														$DatoTipo = $FilaTipo["DT_TIPO"];

														//Query para traer datos por deducible
														$QueryDeducible = "SELECT DT_DEDUCIBLE, DT_TOTAL FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = ".$DatoTipo." AND DT_AREA = ".$DatoArea." GROUP BY DT_DEDUCIBLE";
														$ResultDeducible = mysqli_query($db,$QueryDeducible);
														while($FilaDeducible = mysqli_fetch_array($ResultDeducible))
														{

															$Deducible = $FilaDeducible["DT_DEDUCIBLE"];

															
															

															$SaberCuenta = "SELECT ASIGNACION_NOMENCLATURA.AN_CUENTA, NOMENCLATURA.N_NOMBRE 
																			FROM Contabilidad.ASIGNACION_NOMENCLATURA, Contabilidad.NOMENCLATURA 
																			WHERE ASIGNACION_NOMENCLATURA.AN_CUENTA = NOMENCLATURA.N_CODIGO
																			AND ASIGNACION_NOMENCLATURA.AN_AREA = ".$DatoArea."
																			AND ASIGNACION_NOMENCLATURA.AN_TIPO = ".$DatoTipo."
																			AND ASIGNACION_NOMENCLATURA.AN_DEDUCIBLE = ".$Deducible."
																			AND ASIGNACION_NOMENCLATURA.AN_DONACION = 0";
															$ResultCuenta = mysqli_query($db,$SaberCuenta);
															$FilaCuenta = mysqli_fetch_array($ResultCuenta);

															$CodigoCuenta = $FilaCuenta["AN_CUENTA"];
															$TotalDepreciacion = $FilaDeducible["DT_TOTAL"];
															$NombreCuenta = $FilaCuenta["N_NOMBRE"];

															?>
															<tr>
																<td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $CodigoCuenta."/".$NombreCuenta ?>" readonly></h6></td>
																<td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="<?php echo $TotalDepreciacion ?>" min="0" readonly></h6></td>
																<td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="0.00"  min="0" readonly></h6></td>
															</tr>
															<?php
														}
                                        			}
                                        		}


                                        		//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE MOBILIARIO Y EQUIPO
                                        		$QueryME = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 1";
                                        		$ResultME = mysqli_query($db,$QueryME);
                                        		$FilaME = mysqli_fetch_array($ResultME);

                                        		$TotalME = $FilaME["TOTAL_ME"];

                                        		if($TotalME != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.005/Depreciación Acumulada Mobiliario y Equipo" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalME ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

                                        		//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE EQUIPO DE COMPUTO
                                        		$QueryEC = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 2";
                                        		$ResultEC = mysqli_query($db,$QueryEC);
                                        		$FilaEC = mysqli_fetch_array($ResultEC);

                                        		$TotalEC = $FilaEC["TOTAL_ME"];

                                        		if($TotalEC != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.007/Depreciación Acumulada Equipo de Computación" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalEC ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

                                        		//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE VEHICULOS
                                        		$QueryV = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 3";
                                        		$ResultV = mysqli_query($db,$QueryV);
                                        		$FilaV = mysqli_fetch_array($ResultV);

                                        		$TotalV = $FilaV["TOTAL_ME"];

                                        		if($TotalV != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.011/Depreciación Acumulada Vehículos" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalV ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

                                        		//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE HERRAMIENTA Y EQUIPO
                                        		$QueryH = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 4";
                                        		$ResultH = mysqli_query($db,$QueryH);
                                        		$FilaH = mysqli_fetch_array($ResultH);

                                        		$TotalH = $FilaH["TOTAL_ME"];

                                        		if($TotalH != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.009/Depreciación Acumulada Herramientas" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalH ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

                                        		//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE SOFTWARE
                                        		$QueryH = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 5";
                                        		$ResultH = mysqli_query($db,$QueryH);
                                        		$FilaH = mysqli_fetch_array($ResultH);

                                        		$TotalH = $FilaH["TOTAL_ME"];

                                        		if($TotalH != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.03.01.002/Amortización Acumulada Software" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalH ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

												//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE Semovientes
                                        		$QueryH = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 6";
                                        		$ResultH = mysqli_query($db,$QueryH);
                                        		$FilaH = mysqli_fetch_array($ResultH);

                                        		$TotalH = $FilaH["TOTAL_ME"];

                                        		if($TotalH != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.015/Depreciación Acumulada Semovientes" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalH ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

												//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE Edificio
                                        		$QueryH = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 7";
                                        		$ResultH = mysqli_query($db,$QueryH);
                                        		$FilaH = mysqli_fetch_array($ResultH);

                                        		$TotalH = $FilaH["TOTAL_ME"];

                                        		if($TotalH != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.02.01.013/Depreciacion Acumulada Construcciones en Terrenos Ajenos" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalH ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}

												//QUERY PARA SABER TOTAL DE LA DEPRECIACION DE gastos INSTALACION
                                        		$QueryH = "SELECT SUM(DT_TOTAL) AS TOTAL_ME FROM Contabilidad.DEPRECIACION_TEMPORAL WHERE DT_TIPO = 8";
                                        		$ResultH = mysqli_query($db,$QueryH);
                                        		$FilaH = mysqli_fetch_array($ResultH);

                                        		$TotalH = $FilaH["TOTAL_ME"];

                                        		if($TotalH != 0)
                                        		{
                                        			?>
													<tr>
			                                            <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.03.01.004/Amortización Acumulada Gastos de Instalación" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]" style="width: 100px" value="0.00" min="0" readonly></h6></td>
			                                            <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" style="width: 100px" value="<?php echo $TotalH ?>"  min="0" readonly></h6></td>
			                                        </tr>
                                        			<?php
                                        		}



                                        	?>
                                            
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos"  readonly style="width: 100px"></h6></td>
                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" disabled>Contabilizar</button>
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
