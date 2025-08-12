<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
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

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<br>
				<div class="card">
					<div class="card-head style-primary">
							<h3 class="text-center"><strong>Tickets por Hotel</strong></h3>
						</div>
						<div class="card-body">
							<div class="row text-center">
								<div class="col-lg-3"></div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="NombreHotel"><h3>Nombre Hotel</h3></label>
										<select name="SelectHotel" class="form-control" id="SelectHotel" required onChange="MostrarTicketHotel(this.value)">
										 <option disabled="" selected>Seleccione una hotel</option>
										 <?php 
											$Hotel = mysqli_query($db, "SELECT H_CODIGO, H_NOMBRE FROM Taquilla.HOTEL");
											while($HotelResult = mysqli_fetch_array($Hotel))
											{
										 ?>				
										 <option value="<?php echo $HotelResult[H_CODIGO]?>"><?php echo $HotelResult[H_NOMBRE]?></option>
										 <?php 
										 	}			
										  ?>
										  <option value="T">Todos</option>
										</select>
									</div>
								</div>	
								<div class="col-lg-3"></div>
							</div>

					<div align="center">
						<img src="../../../../../img/Preloader.gif" width="64" height="64" id="GifCargando" style="display: none">		
					</div>								
				</div>
			</div>
		</div>
	
<div class="container" id="ReporteGenerado" style="display: none">
  <div class="panel-group" id="accordion">
    <div class="panel panel-primary">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        <h3 class="panel-title" align="center">
          Detalle de tickets por Hotel
        </h3>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
			<div id="AjaxDetalleTicket"></div>
        </div>
      </div>
    </div>
  </div>
</div>

		</div><!-- END CONTENT -->
		
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>
	</div><!--end #base-->
	<!-- END BASE -->

	<script>
		function MostrarTicketHotel(CodigoHotel)
		{
			$.ajax({
				url: 'DetalleTicketsHotel.php',
				type: 'POST',
				data: {CodigoHotel: CodigoHotel},
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

	</script>

	</body>
	</html>
