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
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	
	
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
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
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

<script>

function Limpiar()
    {
      $(".selectpicker").selectpicker('val', ''); 
    }
  
</script>

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
							<h3 class="text-center"><strong>Movimientos de los Productos</strong></h3>
						</div>
						<div class="card-body">
							<div > 
								<div >
								</div>	
								<div id="divRango">
									<div class="input-group">
										<label for="fechaInicial"><h3>Fecha Inicial</h3></label>
										<input type="date" id="fechaInicial" name="fechaInicial" class="form-control" value="<?php echo date('Y-m-d') ?>"/>
									</div>
										<div class="input-group">
										<label for="fechaFinal"><h3>Fecha Final</h3></label>
										<input type="date" id="fechaFinal" name="fechaFinal" class="form-control" value="<?php echo date('Y-m-d') ?>"/>
									</div>
									</div>
								</div>
								<div class="row">
                        <div class="col-lg-6 col-lg-6">
                        <div class="form-group">
                        <label  style="color:black"><h4 style="color:#8bc34a">Punto</h4></label>
						<br>
											<select name="Punto" id="Punto" data-live-search="true" class="selectpicker" required>
												<option value="" disabled selected>Seleccione Producto</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM CompraVenta.PUNTO_VENTA ORDER BY PV_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
                                                    
													echo '<option value="'.$row["PV_CODIGO"].'">'.$row["PV_NOMBRE"].'</option>';
												}

												?>
											</select>
											
										
                        </div>
                        </div>
                        </div>
						

								<div class="col-lg-2" id="divBoton"><br><br>
									<button type="button" class="btn btn-info btn-circle"><i class="fa fa-check" onclick="verDetalle()"></i>
                                </button>
								</div>
								
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
      	<h3>CONSOLIDADO</h3>
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
			var Producto = $("#Producto").val();
			var Punto = $("#Punto").val();
			
			 $.ajax({
				url: 'Ajax/DataKardexPuntoPTraslados.php',
				type: 'POST',
				data: {fechaInicial:fechaInicial,fechaFinal:fechaFinal, Producto:Producto, Punto:Punto},
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
						$("#SelectHotel").val("");
						var fechaInicial = $("#fechaInicial").val("");
						var fechaFinal = $("#fechaFinal").val("");
						var Producto = $("#Producto").val("");
						var Punto = $("#Punto").val("");
					}
				}
				})

				
			}

	
</script>
	</body>
	</html>
