<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$MesC = $_GET["Mes"];
$Anho = $_GET["anho"];
$inicio = date("Y-m-01"); 
$fin = date("Y-m-t");
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

    <!-- BEGIN STYLESHEETS -->
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
    <script src="../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
    <!-- END JAVASCRIPT -->

    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
    <link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
 
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

    <?php include("../../../MenuTop.php") ?>
	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container-fluid">
				<form class="form" role="form" id="FRMReporte" action="#" method="GET">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Control Diario</strong></h4> 
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4"> 
                                            <label for="Mes"><h3>Mes</h3></label>
                                            <select name="Mes" id="Mes" class="form-control">
                                                <option selected disabled>Seleccione</option>
                                                <?php 
                                                $Mes = mysqli_query($db, "SELECT *FROM info_base.lista_meses a ORDER BY a.id asc");
                                                while ($RowMes = mysqli_fetch_array($Mes)) { 
                                                ?>
                                                <option value="<?php echo $RowMes["id"]?>"><?php echo $RowMes["mes"] ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select> 
                                    </div>
                                    <div class="col-lg-4"> 
                                            <label for="Anio"><h3>Año</h3></label>
                                             <select name="Anio" id="Anio" class="form-control">
                                                <option selected disabled>Seleccione</option>
                                                <?php 
                                                $ListAnio = mysqli_query($db, "SELECT *FROM info_base.lista_anios a ORDER BY a.id asc");
                                                while ($RowAnio = mysqli_fetch_array($ListAnio)) { 
                                                ?>
                                                <option value="<?php echo $RowAnio["anio"]?>"><?php echo $RowAnio["anio"] ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select> 
                                    </div> 
									<div class="col-md-4"> 
                                            <?php 
                                             $Sql_EstanqueCt = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque as a order by a.Correlativo asc"); 
                                            ?>
                                                <label class="control-label"><h3>No. Estanque</h3></label>
                                                <select name="NoEstanque" id="NoEstanque" class="form-control" onchange="VerDetalle(this.value)" required="">
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
								</div>
								<div id="Detalle"></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT --> 
		<?php include("../MenuUsers.html"); ?> 
		 
	</div><!--end #base-->

	<script>
		function VerDetalle(IdEstanque)
		{
			var Mes =  $("#Mes").val();
			var Anio =  $("#Anio").val();
			$.ajax({
			 	url: 'AJAX/DetalleIngresoMes.php',
			 	type: 'POST',
			 	dataType: 'html',
			 	data: {IdEstanque:IdEstanque, Mes:Mes, Anio:Anio},
			 	success:function(data)
			 	{
			 		$("#Detalle").html(data);
			 	}
			 })  		 			 
		}
	</script>
	<!-- END BASE -->
	</body>
	</html>
