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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css" />
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

	<?php
		$Query = mysqli_query($db, "SELECT * FROM Bodega.TIPO_MONTAJE AS A WHERE A.TM_CODIGO = ".$_GET[Codigo]);

		$Fila = mysqli_fetch_array($Query);

		$Nombre         = $Fila[TM_NOMBRE];
		$Referencia     = $Fila[TM_REFERENCIA];
		$Estado         = $Fila[TM_ESTADO];

	?>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Tipos de Montaje</strong><br></h1>
				<br>
				<form class="form" action="TipoMontajeModPro.php" method="POST" role="form" enctype="multipart/form-data">
					<input type="hidden" name="Codigo" value="<?php echo $_GET[Codigo] ?>">
					<input type="hidden" name="CodigoUnico" value="<?php echo $Referencia ?>">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Tipo de Montaje</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-3">
										<label for="Estado">Estado</label>
										<select class="form-control" name="Estado" id="Estado" required="">
											<option value="1" <?php if($Estado == 1){echo 'selected';} ?>>Activo</option>
											<option value="2" <?php if($Estado == 2){echo 'selected';} ?>>Inactivo</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-offset-1 col-lg-9">
										<table class="table table-hover table-condensed" id="tabla">
											<thead>
												<tr>
													<th>FOTOGRAFÍAS</th>
													<th>OBSERVACIONES</th>
												</tr>
											</thead>
											<tbody>
												<tr class="fila-base">
													<td><input name="Fotografia[]" type="file" accept="image/*"/></td>
													<td><h6><input type="text" class="form-control" name="Observaciones[]" id="Observaciones[]"></h6></td>
													<td><h6><button type="button" class="btn btn-danger eliminar"><span class="glyphicon glyphicon-remove"></span></button></h6></td>
												</tr>
												<tr>
													<td><input name="Fotografia[]" type="file" accept="image/*"/></td>
													<td><h6><input type="text" class="form-control" name="Observaciones[]" id="Observaciones[]"></h6></td>
												</tr>
											</tbody>
										</table>
										<div class="col-lg-12" align="left">
	                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
	                                            <span class="glyphicon glyphicon-plus"></span> Agregar
	                                        </button>
	                                    </div>
									</div>
								</div>
							</div>
							<div class="col-lg-12" align="center">
								<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
							</div>
							<br>
							<br>
						</form>
						</div>
					</div>
					<div class="row">
						<br>
						<br>
						<?php
							$Query = mysqli_query($db, "SELECT * FROM Bodega.FOTOGRAFIA_TIPO_MONTAJE WHERE TM_REFERENCIA = '".$Referencia."'");
							while($Fila = mysqli_fetch_array($Query))
							{
								?>
									<div class="text-center">
                                      <div class="col-sm-3">
                                        <div class="thumbnail">
                                          <a href="<?php echo $Fila[FTM_RUTA] ?>" target="_blank"><img style="width: 259px; height: 194px" src="<?php echo $Fila[FTM_RUTA] ?>" alt="..."></a>
                                          <div class="caption">
                                            <h5><b><?php echo $Fila[FTM_OBSERVACIONES]; ?></b></h5>
                                            <p>
                                                <button type="button" class="btn btn-sm btn-danger" value="<?php echo $Fila[FTM_CODIGO] ?>" onclick="DesenlazarFoto(this)"><span class="glyphicon glyphicon-remove"></span></button>
                                            </p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
								<?php
							}
						?>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

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

	<script>
		function DesenlazarFoto(x)
		{
			alertify.confirm("¿Está seguro que desea eliminar esta fotografía?", function (e) {
			    if (e) {
			        $.ajax({
			        		url: 'EliminarFotografiaTM.php',
			        		type: 'post',
			        		data: 'Codigo='+x.value,
			        		success: function (data) {
			        			if(data == 1)
			        			{
			        				$(x).prop('disabled', true);
			        			}
			        		}
			        	});
			    }
			});
		}
	</script>

	<script>
	$(function(){
        
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#agregar").on('click', function(){
            $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
        });

        // Evento que selecciona la fila y la elimina
        $(document).on("click",".eliminar",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            Calcular();
        });
    });
	</script>

	</body>
	</html>