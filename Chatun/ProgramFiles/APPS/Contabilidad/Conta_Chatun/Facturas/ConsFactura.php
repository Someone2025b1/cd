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

	<script>
        function BuscarCuenta(x){
		        //Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarCuenta.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == '')
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
		            		$('#ModalSugerencias').modal('show');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                    x.value = $(this).attr('id')+"/"+$(this).attr('data');
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                });
			                x.blur();
		            	}
		            }
		        });
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
				<form class="form" action="FacturasRepPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Consulta de Factura</strong></h4>
							</div>
							<div class="card-body">
							<?php
									$TotalCargos = 0;
									$TotalAbonos = 0;

									$query = "SELECT A.*, B.* FROM Contabilidad.TRANSACCION AS A, Contabilidad.PROVEEDOR AS B 
												WHERE A.P_CODIGO = B.P_CODIGO 
												AND A.TRA_CODIGO = '".$_GET["Codigo"]."'";
									$result = mysqli_query($db, $query);
									while($row = mysqli_fetch_array($result))
									{	
										$FechaBien          = $row["TRA_FECHA_TRANS"];
										$Fecha              = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
										$Hora               = $row["TRA_HORA"];
										$Concepto           = $row["TRA_CONCEPTO"];
										$FechaHoy           = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
										$Usuario            = $row["TRA_USUARIO"];
										$Nit                =$row["P_NIT"];
										$ProveedorCodigo    =$row["P_CODIGO"];
										$ProveedorNombre    =$row["P_NOMBRE"];
										$Serie              =$row["TRA_SERIE"];
										$Factura            =$row["TRA_FACTURA"];
										$TipoCompra         =$row["TC_CODIGO"];
										$Combustible        = $row["COM_CODIGO"];
										$DestinoCombustible =$row["TRA_DESTINO_COM"];
										$CantidadGalones    =$row["TRA_CANT_GALONES"];
										$PrecioGalones      =$row["TRA_PRECIO_GALONES"];
										$TotalFactura       =$row["TRA_TOTAL"];
										$FormaPago          =$row["FP_CODIGO"];
										$Usuario            =$row["TRA_USUARIO"];
										$Comprobante        =$row["TRA_COMPROBANTE"];
										$Estado				=$row["E_CODIGO"];
										$Comprobante 		=$row["TRA_NO_HOJA"];
										$MotivoRechazo 		=$row["TRA_MOTIVO_RECHAZO"];
										$SinFP				=$row["TRA_SIN_FP"];
										$TraUsuario			=$row["TRA_USUARIO"];

										if($SinFP == 1)
										{
											$Consulta1 = "SELECT * FROM Contabilidad.DOCUMENTO_PAGO WHERE TRA_CODIGO = '".$_GET["Codigo"]."'";
										    $Resultado1 = mysqli_query($db, $Consulta1);
										    while($row = mysqli_fetch_array($Resultado1))
										    {
										        $IDFotografia2   = $row["DP_CODIGO"];
										        $RutaFotografia2 = $row["DP_RUTA"];
										    }
										}
									}
									
									$sqlRet = mysqli_query($db,"SELECT A.nombre 
												FROM info_bbdd.usuarios AS A     
												WHERE A.id_user = ".$TraUsuario); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombreUsuario=$rowret["nombre"];
										?>
								
								
								<form class="form" role="form">
								<?php
									if($Estado == 2)
									{
										?>
										<div class="row">
											<div class="col-lg-6">
													<div class="form-group">
														<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Comprobante; ?>" readonly/>
														<label for="Nombre">Comprobante</label>
													</div>
											</div>
											<div class="col-lg-6">
													<div class="form-group">
														<input class="form-control" type="text" name="NombreUsuarioIngreso" id="NombreUsuarioIngreso" value="<?php echo $NombreUsuario; ?>" readonly/>
														<label for="NombreUsuarioIngreso">Nombre Usuario Ingreso</label>
													</div>
											</div>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="row">
											<div class="col-lg-10">
													<div class="form-group">
														<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $MotivoRechazo; ?>" readonly/>
														<label for="Nombre">Motivo Rechazo</label>
													</div>
											</div>
										</div>
										<?php
									}
								?>
									<div class="row">
										<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $ProveedorNombre; ?>" readonly/>
													<label for="Nombre">Proveedor</label>
												</div>
										</div>
										<div class="col-lg-4">
												<div class="form-group">
													<input class="form-control" type="text" name="CodigoProveedor" id="CodigoProveedor" value="<?php echo $ProveedorCodigo; ?>" readonly/>
													<label for="CodigoProveedor">Cuenta Contable</label>
												</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $Nit; ?>" readonly/>
												<label for="NIT">NIT</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control" type="text" name="SerieFactura" id="SerieFactura" value="<?php echo $Serie; ?>" readonly/>
												<label for="SerieFactura">No. de Serie</label>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="Factura" id="Factura" value="<?php echo $Factura; ?>" readonly/>
												<label for="Factura">No. de Factura</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaBien; ?>" readonly/>
												<label for="Fecha">Fecha Factura</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group floating-label">
												<textarea class="form-control" name="Descripcion" id="Descripcion" readonly><?php echo $Concepto; ?></textarea>
												<label for="Descripcion">Descripción</label>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<h5>Tipo</h5>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="B" name="TipoCompra" <?php if($TipoCompra == 'B'){echo 'checked';} ?> disabled>
											<span>Bienes</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="C" name="TipoCompra" <?php if($TipoCompra == 'C'){echo 'checked';} ?> disabled>
											<span>Combustible</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="I" name="TipoCompra" <?php if($TipoCompra == 'I'){echo 'checked';} ?> disabled>
											<span>Importación</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="S" name="TipoCompra" <?php if($TipoCompra == 'S'){echo 'checked';} ?> disabled>
											<span>Servicios</span>
										</label>
									</div>
									<div id="DivCombustibles" <?php if($TipoCompra == 'C'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?> >
										<div class="row">
											<div class="col-lg-6 col-lg-6">
												<div class="form-group">
													<select name="Combustible" id="Combustible" class="form-control" disabled>
														<?php
		                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
		                                                    $query = "SELECT * FROM Contabilidad.COMBUSTIBLE ORDER BY COM_NOMBRE";
		                                                    $result = mysqli_query($db, $query);
		                                                    while($row = mysqli_fetch_array($result))
		                                                    {
		                                                    	if($row["COM_CODIGO"] == $Combustible)
		                                                    	{
		                                                    		$Selected = 'selected';
		                                                    	}
		                                                    	else
		                                                    	{
		                                                    		$Selected = '';
		                                                    	}
		                                                        echo '<option value="'.$row["COM_CODIGO"].'" '.$Selected.'>'.$row["COM_NOMBRE"].'</option>';
		                                                    }

		                                                ?>
													</select>
													<label for="Combustible">Tipo de Combustible</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="DestinoCombustibles" id="DestinoCombustibles" value="<?php echo $DestinoCombustible; ?>" readonly/>
													<label for="DestinoCombustibles">Destino</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="CantidadGalones" id="CantidadGalones" value="<?php echo $CantidadGalones; ?>" readonly/>
													<label for="CantidadGalones">Cantidad de Galones</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="PrecioGalones" id="PrecioGalones" value="<?php echo $PrecioGalones; ?>" readonly/>
													<label for="PrecioGalones">Precio por Galon</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group">
													<input class="form-control" type="number" name="TotalCombustible" id="TotalCombustible" value="<?php echo $TotalFactura; ?>" readonly />
													<label for="TotalCombustible">Total</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row"><br></div>
									<div id="DivProductosServicios" <?php if($TipoCompra == 'B'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="TotalFactura" id="TotalFactura" value="<?php echo $TotalFactura; ?>" readonly/>
													<label for="TotalFactura">Total de Factura</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<select name="FormaPago" id="FormaPago" class="form-control" onchange="ComprobarFormaPago(this.value)" disabled>
													<option value="" disabled selected>Seleccione una opción</option>
													<option value="C" <?php if($FormaPago == 'C'){echo 'selected';} ?> >Cheque</option>
													<option value="D" <?php if($FormaPago == 'D'){echo 'selected';} ?> >Depósito</option>
												</select>
												<label for="FormaPago">Forma de Pago</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
											<input class="form-control" type="text" name="Documento" id="Documento" value="<?php echo $Comprobante; ?>" readonly/>
												<label for="Documento">No. de Cheque/Depósito</label>
											</div>
										</div>
									</div>
									<div class="row">
										<table class="table table-hover table-condensed" name="tabla" id="tabla">
	                                        <thead>
	                                            <tr>
	                                                <td><strong>Cuenta</strong></td>
	                                                <td><strong>Nombre</strong></td>
	                                                <td><strong>Cargos</strong></td>
	                                                <td><strong>Abonos</strong></td>
	                                                <td><strong>Razón</strong></td>
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                        <?php
	                                        	$query = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
	                                        				FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
	                                        				WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
	                                        				AND TRANSACCION_DETALLE.TRA_CODIGO = '".$_GET["Codigo"]."'";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<tr>';
														echo '<td>'.$row["N_CODIGO"].'</td>';
														echo '<td>'.$row["N_NOMBRE"].'</td>';
														echo '<td>'.$row["TRAD_CARGO_CONTA"].'</td>';
														echo '<td>'.$row["TRAD_ABONO_CONTA"].'</td>';
														echo '<td>'.$row["TRAD_RAZON"].'</td>';
													echo '</tr>';
													$TotalCargos = $TotalCargos + $row["TRAD_CARGO_CONTA"];
													$TotalAbonos = $TotalAbonos + $row["TRAD_ABONO_CONTA"];
												}
	                                        ?>
	                                        </tbody>
	                                        <tfoot>
	                                        	<tr>
	                                        		<td></td>
	                                        		<td class="text-right"><b>Total</b></td>
	                                                <td align="center"><b><?php echo number_format($TotalCargos, 2, '.', ','); ?></b></td>
	                                                <td align="center"><b><?php echo number_format($TotalAbonos, 2, '.', ','); ?></b></td>
	                                                <td></td>
	                                        	</tr>
	                                        </tfoot>
	                                    </table>
									</div>
									<?php
									if($SinFP == 1)
									{
										?>
										<div class="row">
											<div class="col-lg-12 text-center">
												<div class="form-group">
													<a href="<?php echo $RutaFotografia2 ?>" target="_blank"><img src="<?php echo $RutaFotografia2 ?>" alt="" class="img-thumbnail" width="200" height="100"></a>
													<label for="FormaPago">Comprobante de Pago</label>
												</div>
											</div>
										</div>
										<?PHP
									}									
									?>
								</form>

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

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
