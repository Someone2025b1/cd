<?php
include("../../../../../Script/funciones.php");
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
	<script src="../../../../../js/libs/dropzone/dropzone.min.js"></script>

	
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/dropzone/dropzone-theme.css" />
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="AdjuntarProPro.php" method="POST" role="form" enctype="multipart/form-data">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Adjuntar Documento de Pago a Factura de Compra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php

									$Referencia = uniqid();
									$Centinela = true;

									$CodigoTransaccion = $_POST["CodigoTransaccion"];


									//Loop para recorrer todos los archivos
			                        for($i=0; $i<count($_FILES['Documento']['name']); $i++) 
			                        {
			                            //Obtener el nombre temporal del archivo
			                            $tmpFilePath = $_FILES['Documento']['tmp_name'][$i];

			                            //Asegurarse que existe el nombre temporal
			                            if ($tmpFilePath != "")
			                            {
			                                //Bloque de código para darle surir el archivo
			                                //Bloque para saber la extensión del archivo
			                                $archivo = basename( $_FILES['Documento']['name'][$i]); 
			                                $trozos = explode(".", $archivo); 
			                                $extension = end($trozos);    

			                                //Darle la ruta y el nombre al archivo a guardar
			                                $newFilePath = "files/";
			                                $newFilePath = $newFilePath . uniqid('file_') . '.' . $extension;

			                                //Subir el Archivo
			                                if(move_uploaded_file($tmpFilePath, $newFilePath)) //Comprobar si no existe un error en la subida
			                                {
			                                    //Query para almacenar el path del archivo que se acaba de subir en la base de datos
			                                    $sql = mysqli_query($db, "INSERT INTO Contabilidad.DOCUMENTO_PAGO (DP_REFERENCIA, DP_RUTA, TRA_CODIGO) 
			                                                       VALUES ('". $Referencia ."', '". $newFilePath ."', '".$CodigoTransaccion."')") or die(mysqli_error($sql));

			                                    if(!$sql) //Comprobar si existió algún error en la transacción anterior
			                                    {
			                                        echo '<div class="col-lg-12 text-center">
														<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
														<h2 class="text-light">Lo sentimos, no se pudo adjuntar el documento de pago a la factura de compra.</h2>
														<h4 class="text-light">Código de transacción: '.$Referencia.'</h4>
													</div>';
												echo mysqli_error($sql);
												$Centinela = false;
												
			                                    }
			                                }
			                                else //Comprobar si existió un error en la subida
			                                {
			                                    echo '<div class="col-lg-12 text-center">
														<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
														<h2 class="text-light">Lo sentimos, no se pudo adjuntar el documento de pago a la factura de compra.</h2>
														<h4 class="text-light">Código de transacción: '.$Referencia.'</h4>
													</div>';

			                                    //Detener ejecución del código
			                                    
			                                    $Centinela = false;
			                                }
			                            }
			                        }
			                        if($Centinela == true)
			                        {
			                        	$Consulta = "UPDATE Contabilidad.TRANSACCION SET TRA_SIN_FP = 1 WHERE TRA_CODIGO = '".$CodigoTransaccion."'";
			                        	$Result = mysqli_query($db, $Consulta) or die(mysqli_error());

			                        	if($sql)
			                        	{
			                        		echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
												<h2 class="text-light">El documento de pago se adjunto correctamente.</h2>
												<div class="row">
													<div class="col-lg-6 text-right"><a href="ConsFactura.php?Codigo='.$CodigoTransaccion.'"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Consultar</a></div>';
			                        	}
			                        	else
			                        	{
			                        		echo '<div class="col-lg-12 text-center">
														<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
														<h2 class="text-light">Lo sentimos, no se pudo adjuntar el documento de pago a la factura de compra.</h2>
														<h4 class="text-light">Código de transacción: '.$Referencia.'</h4>
													</div>';

			                        	}
			                        	
			                        }

									?>
								</div>
							</div>
						</div>
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
