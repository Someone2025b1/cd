<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
		function ObtenerDepartamentosLaborales(Valor)
	{
		$.ajax({
			url: 'BuscarDepartamentosLaborales.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#Puesto').html(opciones);
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}

	function LlenarTablaArea(x)
    	{
			
    		$.ajax({
				url: 'LlenarTablaArea.php',
				type: 'post',
				data: 'id='+x,
				success: function (data) {
					$('#TablaArea').html(data);
				}
			});
    	}

		function LlenarTablaPuesto(x)
    	{
			
    		$.ajax({
				url: 'LlenarTablaPuesto.php',
				type: 'post',
				data: 'id='+x,
				success: function (data) {
					$('#TablaPuesto').html(data);
				}
			});
    	}

	function SelColaborador(x)
		{
			window.open('SelColaborador.php','popup','width=750, height=700');

		}

		function CalcularTotal(x){
			
			var Punteo = document.getElementsByName('Punteo'+x+'[]');
			var cant = 0;
			var Total = 0;
			var Promedio = 0;
			var Esperado = 0;
			
			var Punt = 0;

			for(i = 0; i < Punteo.length; i++)
			{
				
				Punt =  parseFloat(Punteo[i].value);

				if(Punt>0){

					Total = Total + Punt;

				}
				
				Esperado = Esperado + 100;
				cant = cant +1;
				
			}

			

			Promedio=(Total)/cant;
			$('#PromedioArea'+x).val(Promedio.toFixed(2));
			$('#PromedioAreaR'+x).val(Promedio.toFixed(2)+"%");
			$('#EsperadoAreaR'+x).val(Esperado.toFixed(2)+"Pts");
			$('#ObtenidoAreaR'+x).val(Total.toFixed(2)+"Pts");

			TotalesGrafica();



		}

		


	
		</script>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>



  <script src="RGraph/libraries/RGraph.common.core.js" ></script>
    <script src="RGraph/libraries/RGraph.common.tooltips.js" ></script>
    <script src="RGraph/libraries/RGraph.common.dynamic.js" ></script>
    <script src="RGraph/libraries/RGraph.pie.js" ></script>
<script src="RGraph/libraries/RGraph.radar.js"></script>
<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor
$etiquetas =["Medición de logros...", "Medición de aceptacion y cumplimiento...", "Valuación de aspectos actitudinales...",
"PUESTO"];
$datosVentas = [16, 20, 12, 16, 16, 8, 12];
$datosVentas2 = [10, 15, 9, 8, 7, 4, 6];



$CodigoE = $_GET["Codigo"];

$sqlRet = mysqli_query($db,"SELECT A.*
	FROM RRHH.EVALUACION_DES_RESUMEN AS A     
	WHERE A.ED_CODIGO = '$CodigoE'"
	); 
	$rowret=mysqli_fetch_array($sqlRet);

	while($row = mysqli_fetch_array($result))
	{

	$Obtenido = [16, 20, 12, 16, 16, 8, 12];
	$Esperado = [10, 15, 9, 8, 7, 4, 6];

	}



$query = "SELECT A.*, B.C_NOMBRES, B.C_APELLIDOS, B.A_CODIGO, B.P_CODIGO
				FROM RRHH.EVALUACION_DESEMPENO AS A, RRHH.COLABORADOR AS B
				WHERE A.C_CODIGO = B.C_CODIGO
				AND A.ED_CODIGO = '$CodigoE'
				ORDER BY A.ED_FECHA";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	

		$Nombres       =  $row["C_NOMBRES"];
		$Apellidos = $row["C_APELLIDOS"];
		$DPI        = $row["C_DPI"];
		$CodigoC = $row["C_CODIGO"];

		$Area = $row["A_CODIGO"];
		$CodigoPuesto = $row["P_CODIGO"];

		$sqlRet = mysqli_query($db,"SELECT A.A_NOMBRE 
		FROM RRHH.AREAS AS A     
		WHERE A.A_CODIGO = ".$Area); 
		$rowret=mysqli_fetch_array($sqlRet);

		$NomArea=$rowret["A_NOMBRE"];

		$sqlRet = mysqli_query($db,"SELECT A.P_NOMBRE 
		FROM RRHH.PUESTO AS A     
		WHERE A.P_CODIGO = ".$CodigoPuesto); 
		$rowret=mysqli_fetch_array($sqlRet);

		$NomPuesto=$rowret["P_NOMBRE"];
		
	
	}

?>





</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Evaluación De Desempeño</strong><br></h1>
				<br>
				<form action="AgregarEvaluacionPro.php" method="POST" class="form" enctype="multipart/form-data">
				<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Datos del Colaborador</strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
							<div class="row">
							<script>
	LlenarTablaArea(7);
	LlenarTablaPuesto(15);
	</script>
									<div class="col-lg-6">
										<div class="form-group ">
										<label for="NombreResponsable">Nombre del Colaborador</label>
											<input class="form-control" type="text" name="NombreResponsable" id="NombreResponsable" value="<?php echo $Nombres." ".$Apellidos; ?>" readonly/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group ">
										<label for="NombreResponsable">Codigo</label>
											<input class="form-control" type="text" name="Codigo" id="Codigo" value="<?php echo $CodigoC; ?>" readonly/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group ">
										<label for="Area">Área</label>
											<input class="form-control" type="text" name="Area" id="Area" value="<?php echo $NomArea; ?>"  onchange="LlenarTablaArea()" readonly/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group ">
										<label for="Puesto">Puesto</label>
											<input class="form-control" type="text" name="Puesto" id="Puesto" value="<?php echo $NomPuesto; ?>" readonly />
										</div>
									</div>
									
								</div>
							</div>

							
						</div>
					</div>
				</div>
		<?php
		$i=1;
						//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
				$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO <> 8 AND  AREA_EVALUAR.AR_CODIGO <> 9 ORDER BY AR_CODIGO";
				$result = mysqli_query($db, $query);
				while($row = mysqli_fetch_array($result))
				{
					$CodAre=$row["AR_CODIGO"];
					$NombreAre=$row["AR_NOMBRE"];

				?>
				<!-- Area a Evaluar -->
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong><?php echo $NombreAre ?></strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
							<div class="row">
							<table class="table" name="tabla" id="tabla">
								<thead>
									<tr>
										<th>Aspecto</th>
										<th>Punteo</th>
									</tr>
								</thead>
								<tbody>
								<?php
							$Aspecto = "SELECT A.ARE_NOMBRE, B.*
							FROM RRHH.ASPECTOS_EVALUAR AS A, RRHH.EVALUACION_DETALLE AS B
							WHERE B.ED_CODIGO = '$CodigoE'  
							AND A.ARE_CODIGO = B.AR_CODIGO
							AND B.ARE_CODIGO = $CodAre
							ORDER BY B.AR_CODIGO";
							$resultAs = mysqli_query($db, $Aspecto);
							while($roweas = mysqli_fetch_array($resultAs))
							{
								$NombreAspecto=$roweas["ARE_NOMBRE"];
								$CodigoAspecto=$roweas["ARE_CODIGO"];
								$Punteo=$roweas["EDD_PUNTEO"];
								?>	
								  <tr>
								<td><h6><input type="Text" class="form-control" name="Aspecto<?php echo $CodAre ?>[]" id="Aspecto<?php echo $CodAre ?>[]"   style="width: 800px" value="<?php echo $NombreAspecto; ?>" readonly></h6></td>
								<input type="hidden" class="form-control" name="CodigoAspecto<?php echo $CodAre ?>[]" id="CodigoAspecto<?php echo $CodAre ?>[]" value="<?php echo $CodigoAspecto; ?>">
						        <td><h6><input type="number" class="form-control" name="Punteo<?php echo $CodAre ?>[]" id="Punteo<?php echo $CodAre ?>[]" style="width: 50px"  max="100" min="0" onChange="CalcularTotal(<?php echo $CodAre ?>)" value="<?php echo $Punteo; ?>" readonly></h6></td>
								  </tr>		
									

								<?php
							}

							$sqlRet = mysqli_query($db,"SELECT A.* 
										FROM RRHH.EVALUACION_DES_RESUMEN AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.AR_CODIGO = ".$CodAre
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Promedio=number_format($rowret["EVDR_PROMEDIO"], 2, '.', ',');
										$Observaciones = $rowret["EVDR_OBSERVACIONES"];

							
							?>

							</tbody>
								<tfoot>
								<td><h6><input type="text" class="form-control" name="TotalArea<?php echo $CodAre ?>" id="TotalArea<?php echo $CodAre ?>"  style="width: 500px; color:red" value="PROMEDIO TOTAL DEL ÁREA" readonly></h6></td>
						        <td><h6><input type="text" class="form-control" name="PromedioArea<?php echo $CodAre ?>" id="PromedioArea<?php echo $CodAre ?>" style="width: 50px" value="<?php echo $Promedio; ?>" readonly></h6></td>
								<td><input type="Text" class="form-control" style="width: 20px" value="%" disabled></td>
								</tfoot>
							</table>		
							
							<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Observaciones<?php echo $CodAre ?>">Observaciones</label>
										<textarea class="form-control" name="Observaciones<?php echo $CodAre ?>" id="Observaciones<?php echo $CodAre ?>" rows="2" cols="40"><?php echo $Observaciones ?></textarea>
										</div>
									</div>
									</div>

								</div>
							</div>

							
						</div>
					</div>
				</div><!-- Termina Area a Evaluar -->
				
				<?php
				$i=$i+1;
				}
				
			


				?>
				<!--

<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong ><input type="text" class="form-control" name="NArea" id="NArea" style="color:white; text-align: center;" align="center" disabled></strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
							<div class="row">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Aspecto</th>
										<th>Punteo</th>
									</tr>
								</thead>
								<tbody id="TablaArea">

								<?php
								$Aspecto = "SELECT * FROM RRHH.ASPECTOS_EVALUAR WHERE ASPECTOS_EVALUAR.AR_CODIGO = 8 AND ASPECTOS_EVALUAR.A_CODIGO = ".$Area." ORDER BY AR_CODIGO";
								$resultAs = mysqli_query($db, $Aspecto);
								while($roweas = mysqli_fetch_array($resultAs))
								{
									$NombreAspecto=$roweas["ARE_NOMBRE"];
									$CodigoAspecto=$roweas["ARE_CODIGO"];
									$CodArea=8;

									$sqlRet = mysqli_query($db,"SELECT A.*
										FROM RRHH.EVALUACION_DETALLE AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.ARE_CODIGO = ".$CodArea."
										AND A.AR_CODIGO = ".$CodigoAspecto
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Punteo=$rowret["EDD_PUNTEO"];
										$Observaciones = $rowret["EVDR_OBSERVACIONES"];
									
								
								
										echo '<tr>';
										
										echo '<td><h6><input type="Text" class="form-control" name="Aspecto8[]" id="Aspecto8[]"  style="width: 800px" value="'.$NombreAspecto.'" readonly></h6></td>';
											echo'<input type="hidden" class="form-control" name="CodigoAspecto8[]" id="CodigoAspecto8[]" value="'.$CodigoAspecto.'" readonly>';
											echo' <td><h6><input type="number" class="form-control" name="Punteo8[]" id="Punteo8[]" style="width: 50px" max="100" min="0" value="'.$Punteo.'" onChange="CalcularTotal('.$CodArea.')" readonly></h6></td>';
											 
											echo '</tr>';
									}

									$sqlRet = mysqli_query($db,"SELECT A.EVDR_PROMEDIO 
										FROM RRHH.EVALUACION_DES_RESUMEN AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.AR_CODIGO = ".$CodArea
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Promedio=number_format($rowret["EVDR_PROMEDIO"], 2, '.', ',');
									?>
							
							</tbody>
								<tfoot>
								<td><h6><input type="text" class="form-control" name="TotalArea8" id="TotalArea8"  style="width: 500px; color:red" value="PROMEDIO TOTAL DEL ÁREA" ></h6></td>
						        <td><h6><input type="text" class="form-control" name="PromedioArea8" id="PromedioArea8" style="width: 50px" value="<?php echo $Promedio; ?>" readonly></h6></td>
								<td><input type="Text" class="form-control" style="width: 20px" value="%" disabled></td>	
							</tfoot>
							</table>		
							
									
								</div>
							</div>

							
						</div>
					</div>
				</div> Termina Area a Evaluar -->
			
				
<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong ><input type="text" class="form-control" name="NPuesto" id="NPuesto" style="color:white; text-align: center;" align="center" value="<?php echo $NomPuesto; ?>" disabled></strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
							<div class="row">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Aspecto</th>
										<th>Punteo</th>
									</tr>
								</thead>
								<tbody id="TablaPuesto">

								<?php
								$Aspecto = "SELECT * FROM RRHH.ASPECTOS_EVALUAR WHERE ASPECTOS_EVALUAR.AR_CODIGO = 9 AND ASPECTOS_EVALUAR.P_CODIGO = ".$CodigoPuesto." ORDER BY AR_CODIGO";
								$resultAs = mysqli_query($db, $Aspecto);
								while($roweas = mysqli_fetch_array($resultAs))
								{
									$NombreAspecto=$roweas["ARE_NOMBRE"];
									$CodigoAspecto=$roweas["ARE_CODIGO"];
									$CodArea=9;

									$sqlRet = mysqli_query($db,"SELECT A.*
										FROM RRHH.EVALUACION_DETALLE AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.ARE_CODIGO = ".$CodArea."
										AND A.AR_CODIGO = ".$CodigoAspecto
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Punteo=$rowret["EDD_PUNTEO"];
									
								
								
									echo '<tr>';
										
										echo '<td><h6><input type="Text" class="form-control" name="Aspecto9[]" id="Aspecto9[]"  style="width: 800px" value="'.$NombreAspecto.'" readonly></h6></td>';
											echo'<input type="hidden" class="form-control" name="CodigoAspecto9[]" id="CodigoAspecto9[]" value="'.$CodigoAspecto.'" readonly>';
											echo' <td><h6><input type="number" class="form-control" name="Punteo9[]" id="Punteo9[]" style="width: 50px" value="'.$Punteo.'" max="100" min="0" onChange="CalcularTotal('.$CodArea.')" readonly></h6></td>';
											 
										echo '</tr>';
									}

									$sqlRet = mysqli_query($db,"SELECT A.*
										FROM RRHH.EVALUACION_DES_RESUMEN AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.AR_CODIGO = ".$CodArea
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Promedio=number_format($rowret["EVDR_PROMEDIO"], 2, '.', ',');
										$Observaciones = $rowret["EVDR_OBSERVACIONES"];
									?>
							
									</tbody>
										<tfoot>
											<td><h6><input type="text" class="form-control" name="TotalArea9" id="TotalArea9"  style="width: 500px; color:red" value="PROMEDIO TOTAL DEL ÁREA" ></h6></td>
											<td><h6><input type="text" class="form-control" name="PromedioArea9" id="PromedioArea9" value="<?php echo $Promedio; ?>" style="width: 50px" readonly></h6></td>
											<td><input type="Text" class="form-control" style="width: 20px" value="%" disabled></td>
										</tfoot>
									</table>

									<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Observaciones9">Observaciones</label>
										<textarea class="form-control" name="Observaciones9" id="Observaciones9" rows="2" cols="40"><?php echo $Observaciones ?></textarea>
										</div>
									</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div><!-- Termina Area a Evaluar -->

				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-danger">
						<h4 class="text-center"><strong >RESULTADO DE LA VALUACIÓN</strong></h4>
						</div>
						<div class="card-body">

						<div class="col-lg-8">
						
						<canvas id="grafica" readonly=""></canvas>

						<br>
						<br>
						<br>
						<br>
						
						<input style="font-size:24px;" type="text" class="form-control" name="PromedioTotal" id="PromedioTotal" readonly>
						
						
						</div>
						<div class="col-lg-4">
							<table class="table table-hover" style="font-size:10px;">
							<thead>
									<tr>
										<th>Área</th>
										<th>Promedio</th>
										<th>Puntos</th>
										<th>Esperado</th>
										<th>Anterior</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO <> 8 AND  AREA_EVALUAR.AR_CODIGO <> 9 ORDER BY AR_CODIGO";
									$result = mysqli_query($db, $query);
									while($row = mysqli_fetch_array($result))
									{
										$CodAre=$row["AR_CODIGO"];
										$NombreAre=$row["AR_NOMBRE"];

										$sqlRet = mysqli_query($db,"SELECT A.*
										FROM RRHH.EVALUACION_DES_RESUMEN AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.AR_CODIGO = ".$CodAre
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Promedio=number_format($rowret["EVDR_PROMEDIO"], 2, '.', ',');
										$PunteoO=number_format($rowret["EVDR_PUNTEO"], 2, '.', ',');
										$PunteoE=number_format($rowret["EVDR_PUNTEO_POS"], 2, '.', ',');
										$UltimoO=number_format($rowret["EVDR_ANTERIOR"], 2, '.', ',');
										?>
									<tr>
										<th>
										<?php
										echo $NombreAre;
										?>
										</th>
										
										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="PromedioAreaR<?php echo $CodAre ?>" id="PromedioAreaR<?php echo $CodAre ?>" value="<?php echo $Promedio."%"; ?>" readonly>
										</th>
									

										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="ObtenidoAreaR<?php echo $CodAre ?>" id="ObtenidoAreaR<?php echo $CodAre ?>" value="<?php echo $PunteoO; ?>" readonly>
										</th>
										

										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="EsperadoAreaR<?php echo $CodAre ?>" id="EsperadoAreaR<?php echo $CodAre ?>" value="<?php echo $PunteoE; ?>" readonly>
										</th>

										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="UltimoObtenido<?php echo $CodAre ?>" id="UltimoObtenido<?php echo $CodAre ?>" value="<?php echo $UltimoO; ?>"  readonly>
										</th>

										</tr>
										<script>					
									TotalesGrafica();	
										</script>

										<?php
									}
										?>

										
										


										<tr>
										<th>
										PUESTO DE TRABAJO
										</th>
										<?php
										$sqlRet = mysqli_query($db,"SELECT A.*
										FROM RRHH.EVALUACION_DES_RESUMEN AS A     
										WHERE A.ED_CODIGO = '$CodigoE'
										AND A.AR_CODIGO = 9"
										); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Promedio=number_format($rowret["EVDR_PROMEDIO"], 2, '.', ',');
										$PunteoO=number_format($rowret["EVDR_PUNTEO"], 2, '.', ',');
										$PunteoE=number_format($rowret["EVDR_PUNTEO_POS"], 2, '.', ',');
										$UltimoO=number_format($rowret["EVDR_ANTERIOR"], 2, '.', ',');

										?>
										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="PromedioAreaR9" id="PromedioAreaR9" value="<?php echo $Promedio."%"; ?>" readonly>
										</th>

										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="ObtenidoAreaR9" id="ObtenidoAreaR9" value="<?php echo $PunteoO; ?>" readonly>
										</th>
										

										<th>
										<input style="font-size:8px;" type="text" class="form-control" name="EsperadoAreaR9" id="EsperadoAreaR9" value="<?php echo $PunteoE; ?>" readonly>
								</th>
								<th>
										<input style="font-size:8px;" type="text" class="form-control" name="UltimoObtenido9" id="UltimoObtenido9"  value="<?php echo $UltimoO; ?>"  readonly>
										</th>
									</tr>
								</tbody>
							</table>
							
						</div>

						</div>
					</div>
					
				</div><!-- Termina Area a Evaluar -->

				

				<div class="col-lg-12" align="center">
			<a href=<?php echo "ImpEvaluacion.php?Codigo=".$CodigoE ?>><button type="button" class="btn btn-dark">
			<span class="fa fa-print"> IMPRIMIR</span>
			</button></a>
					</div>


			</div>

			<?php include("../MenuUsers.html"); ?>

			<br>
					<br>
					</div>
				</form>

		</div><!--end #base-->
		<!-- END BASE -->

		<script type="text/javascript">
        function TotalesGrafica()
		{
			const esperado = [];
			const obtenido = [];
			const ultimoo = [];
			var esperado1 =0;
			var ultimoo1 =0;
			var obtenido1 =0;
			var EsperadoT = 0;
			var ObtenidoT = 0;
			var PromTotal = 0;
			var PromedioT = 0;
			var Prome = 0;
			 
			for(i = 1; i <= 9; i++)
			{
				
				esperado1 = parseFloat($('#EsperadoAreaR'+i).val());

				esperado.push(esperado1);


				obtenido1 = parseFloat($('#ObtenidoAreaR'+i).val());
				

				obtenido.push(obtenido1);

				ultimoo1 = parseFloat($('#UltimoObtenido'+i).val());
				

				ultimoo.push(ultimoo1);


				PromedioT = parseFloat($('#PromedioAreaR'+i).val());
				Prome=Prome+PromedioT;

				if(i==3){
					i=8;
				}

				
			}

			PromTotal=Prome/4;
			$('#PromedioTotal').val("Promedio Total Obtenido: "+PromTotal.toFixed(2)+"%");

			

			// Obtener una referencia al elemento canvas del DOM
			const $grafica = document.querySelector("#grafica");
        // Pasaamos las etiquetas desde PHP
        const etiquetas = <?php echo json_encode($etiquetas) ?>;
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const datosVentas2020 = {
            label: "Esperado",
            // Pasar los datos igualmente desde PHP
            data: esperado,
            backgroundColor: 'rgba(5, 175, 18, 0.2)', // Color de fondo
            borderColor: 'rgba(5, 175, 18, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        }
		const datosVentas2024 = {
            label: "Ultima Evaluación",
            // Pasar los datos igualmente desde PHP
            data: ultimoo,
            backgroundColor: 'rgba(236, 244, 77, 0.2)', // Color de fondo
            borderColor: 'rgba(236, 244, 77, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        }
		const datosVentas2021 = {
            label: "Colaborador",
            // Pasar los datos igualmente desde PHP
            data: obtenido,
            backgroundColor: 'rgba(255, 0, 15, 0.2)', // Color de fondo
            borderColor: 'rgba(255, 0, 15, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };
        new Chart($grafica, {
            type: 'line', // Tipo de gráfica
            data: {
                labels: etiquetas,
                datasets: [
                    datosVentas2020, datosVentas2021, datosVentas2024,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });

		}
		window.onload = function() {
			TotalesGrafica();
};
		
    </script>

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
