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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="RPPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Personas en Lista Negra</strong></h4>
							</div>
							<div class="card-body">
								<?php
									$CIF = $_POST["CIF"];
									$Razon = $_POST["Razon"];

			                            //Obtener el nombre temporal del archivo
			                            $tmpFilePath = $_FILES['Archivo']['tmp_name'];

			                            //Asegurarse que existe el nombre temporal
			                            if ($tmpFilePath != "")
			                            {
			                                //Bloque de código para darle surir el archivo
			                                //Bloque para saber la extensión del archivo
			                                $archivo = basename( $_FILES['Archivo']['name']); 
			                                $trozos = explode(".", $archivo); 
			                                $extension = end($trozos);    

			                                //Darle la ruta y el nombre al archivo a guardar
			                                $newFilePath = "files/";
			                                $newFilePath = $newFilePath . uniqid('file_') . '.' . $extension;

			                                //Subir el Archivo
			                                if(move_uploaded_file($tmpFilePath, $newFilePath)) //Comprobar si no existe un error en la subida
			                                {
			                                    //Query para almacenar el path del archivo que se acaba de subir en la base de datos
			                                    $Query = mysqli_query($db, "INSERT INTO Taquilla.LISTA_NEGRA(LN_CIF_ASOCIADO, LN_OBSERVACIONES, LN_RUTA_ARCHIVO, LN_CIF_COLABORADOR)
															VALUES($CIF, '".$Razon."', '".$newFilePath."', $id_user)")or die(mysqli_error());

			                                    if(!$sql) //Comprobar si existió algún error en la transacción anterior
			                                    {
			                                       echo '<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
													<h2 class="text-light">La persona se ingresó correctamente.</h2>
													<div class="row">
														<a href="ListaNegra.php">
															<button type="button" class="btn btn-success btn-lg">
																<span class="glyphicon glyphicon-ok-sign"></span> Regresar
															</button>
														</a>
													</div>';
			                                    }
			                                }
			                                else //Comprobar si existió un error en la subida
			                                {
			                                    //Desplegar error
			                                    echo '<div class="alert alert-danger">';
			                                    echo '<h4>';
			                                    echo '<i class="icon fa fa-ban"></i>';
			                                    echo 'Error!';
			                                    echo '</h4>';
			                                    echo 'No se pudo finalizar la transacción en los archivos por archivo. <a href="ListaNegra.php" style="color: #5A5A5A">Click Aqui</a> para regresar.';
			                                    echo '</div>';

			                                    //Volver al estado anterior de la base de datos
			                                    mysqli_query($db, "ROLLBACK");

			                                    //Detener ejecución del código
			                                    
			                                }
			                            }
								?>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
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


	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
