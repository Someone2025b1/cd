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

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Editar Personas en Lista Negra</strong></h4>
							</div>
							<div class="card-body">
								<form action="ListaNegraEditPro.php" method="POST" class="form" enctype="multipart/form-data">
									<div class="row text-center">
										<?php 
										$CIF=$_GET["Codigo"];
										$Query = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA WHERE LN_CIF_ASOCIADO = '".$CIF."' ORDER BY LN_FECHA_HORA");
										while($Fila = mysqli_fetch_array($Query))
										{
											$Descripcion = $Fila["LN_OBSERVACIONES"];
											$ci=$Fila["LN_CIF_ASOCIADO"];
										
										?>
										
									</div>
									<div class="row">
										<div align="center" id="div_cargando" style="display: none">
											<img src="../../../../../img/Preloader.gif" alt="" width="75px">
										</div>
									</div>
									<div class="row">
									
										<div class="form-group col-lg-12">
											<input class="form-control" type="text" name="CIF" value="<?php echo $CIF ?>" readonly>
											<label for="CIF">CIF</label>
										</div>
									</div>
									<div class="row">
									
										<div class="form-group col-lg-12">
											<input class="form-control" type="text" name="Nombre" value="<?php echo saber_nombre_asociado_orden($CIF) ?>" readonly>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-lg-12">
											<textarea class="form-control" name="Razon" rows="auto" required readonly><?php echo $Fila["LN_OBSERVACIONES"] ?></textarea>
											<label for="Razon">¿Porqué está agregando esta persona a la lista negra?</label>
										</div>
									</div>
									
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Estado" id="Estado" class="form-control" required>
												<option value="1"<?php if($Fila["LN_ESTADO"]==1){ echo 'selected'; } ?>>ACTIVO</option>
                                                <option value="0" <?php if($Fila["LN_ESTADO"]==0){ echo 'selected'; } ?>>INACTIVO</option>
											</select>
											<label for="Estado">Estado de Lista</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Tipo" id="Tipo" class="form-control" required>
												<option value="T" <?php if($Fila["LN_TIPO"]=="T"){ echo 'selected'; } ?>>Total</option>
                                                <option value="P" <?php if($Fila["LN_TIPO"]=="P"){ echo 'selected'; } ?>>Parcial</option>
												<option value="S" <?php if($Fila["LN_TIPO"]=="S"){ echo 'selected'; } ?>>Sin Restricción</option>
											</select>
											<label for="Tipo">Sanción</label>
										</div>
									</div>
									<?php
										}
										?>
									<div class="row text-center">
										<button type="submit" class="btn btn-primary">Enviar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<br>
					<br>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>

		<script>
		function BusquedaAsociado(x)
    	{
    		CriterioBusqueda = $(x).val();
    		
    		if($.isNumeric(CriterioBusqueda))
    		{
	    		$.ajax({
					url: 'BusquedaAsociado.php',
					type: 'POST',
					data: "Criterio="+CriterioBusqueda,
					beforeSend: function() {
				   		$('#div_cargando').show();
				  	},
					success: function (data) 
					{
						$('#div_cargando').hide('fast');
						$('#ResultadoBusquedaAsociado').html(data);
					},
					error: function (data)
					{
						$('#div_cargando').hide();
					}
				});
	    	}
	    	else
	    	{
	    		$.ajax({
					url: 'BusquedaNombre.php',
					type: 'POST',
					data: "Nombre="+CriterioBusqueda,
					beforeSend: function() {
				   		$('#div_cargando').show();
				  	},
					success: function (data) 
					{
						$('#div_cargando').hide('fast');
						$('#suggestions').fadeIn(1000).html(data);
		                //Al hacer click en algua de las sugerencias
		               	$('.suggest-element').click(function(){
		                    var CIF = $(this).attr('data');
		                    AgregarAsociado(CIF);
		                });
					},
					error: function (data)
					{
						$('#div_cargando').hide();
					}
				});
	    	}
    	}
    	function AgregarAsociado(x)
    	{
    		$.ajax({
    				url: 'AgregarAsociadoNombre.php',
    				type: 'post',
    				data: 'Criterio='+x,
    				success: function (data) {
    					$('#ResultadoBusquedaAsociado').html(data);
    					$('#suggestions').fadeOut(1000).html(data);
    				}
    			});
    	}
		</script>


	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
