<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/funciones.php");
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
	<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../js/core/source/App.js"></script>
	<script src="../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../libs/alertify/js/alertify.js"></script>
	<script src="../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../libs/TableFilter/filtergrid.css">
	<!-- Resources -->
	<!-- Resources -->
<script src="graficas/core.js"></script>
<script src="graficas/charts.js"></script>
<script src="graficas/animated.js"></script> 

	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		
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

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base"> 
		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<br>
				<div class="card">
					<div class="card-head style-primary">
							<h3 class="text-center"><strong>Gráfica Control Diario</strong></h3>
						</div>
						<div class="card-body">
							<div class="row text-center">  
								<div class="col-lg-3"> 
										<label for="fechaInicial"><h3>Fecha Inicial</h3></label>
										<input type="date" id="fechaInicial" name="fechaInicial" class="form-control" />
								</div>
								<div class="col-lg-3"> 
										<label for="fechaFinal"><h3>Fecha Final</h3></label>
										<input type="date" id="fechaFinal" name="fechaFinal" class="form-control" /> 
								</div> 
								<div class="col-md-3"> 
                                <?php 
                                 $Sql_EstanqueCt = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque as a order by a.Correlativo asc"); 
                                ?>
                                    <label class="control-label"><h3>No. Estanque</h3></label>
                                    <select name="NoEstanque" id="NoEstanque" class="form-control" required="">
                                        <option selected="" disabled="">Seleccione</option>
                                        <?php 
                                        while ($Fila_EstanqueCt = mysqli_fetch_array($Sql_EstanqueCt)) 
                                        {
                                            $EstanqueSig = $Fila_EstanqueCt['IdEstanque']
                                           ?>
                                           <option value="<?php echo $EstanqueSig?>">No. <?php echo $EstanqueSig?></option>
                                           <?php 
                                        }
                                        ?>                                                        
                                    </select> 
		                        </div>  
								<div class="col-lg-3" id="divBoton"><br><br>
									<button type="button" class="btn btn-info btn-circle"><i class="fa fa-check" onclick="verDetalle()"></i>
                                </button>
								</div>
							</div> 
					<div align="center">
						<img src="../../../../img/Preloader.gif" width="64" height="64" id="GifCargando" style="display: none">		
					</div>	
					<br><br>
					<div id="AjaxDetalleTicket"></div>							
				</div>
			</div>
		</div> 
        </div><!-- END CONTENT -->
		
		
		<?php   
			include("../MenuUsers.html");  
		?>
	</div><!--end #base-->
	<!-- END BASE -->
	<script>
		function verDetalle()
		{
			var fechaInicial = $("#fechaInicial").val(); 
			var fechaFinal = $("#fechaFinal").val(); 
			var NoEstanque = $("#NoEstanque").val();
			 	 $.ajax({
				url: 'Ajax/DetalleControlDiario.php',
				type: 'POST',
				data: {fechaInicial:fechaInicial, fechaFinal:fechaFinal, NoEstanque: NoEstanque},
				beforeSend: function()
				{
					$('#GifCargando').show();
				},
				success: function(data)
				{
					if(data)
					{
						$('#GifCargando').hide();
						$('#ReporteGenerado').show('fast');
						$('#AjaxDetalleTicket').html(data); 
					}
				}
				})
		}

	function optionSelect(x)
	{ 
		if (x==1) 
		{
			$("#divDia").show();
			$("#divMes").hide();
			$("#divAnio").hide(); 
			$("#divRango").hide();
		}
		else if(x==2)
		{
			$("#divDia").hide();
			$("#divMes").show();
			$("#divAnio").hide(); 
			$("#divRango").hide();
		}
		else if(x==3)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").show();
			$("#divRango").hide();
		}
		else if(x==4)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").hide();
			$("#divRango").show();
		} 
		$("#divBoton").show();
	}
	</script>

	</body>
	</html>
