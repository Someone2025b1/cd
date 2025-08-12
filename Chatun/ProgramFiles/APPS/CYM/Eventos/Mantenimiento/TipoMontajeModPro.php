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
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Rancho</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Datos Generales del Rancho</strong></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<?php
									$Nombre      = $_POST["Nombre"];
									$Estado      = $_POST["Estado"];
									$Codigo      = $_POST["Codigo"];
									$CodigoUnico = $_POST["CodigoUnico"];

									$Observaciones = $_POST[Observaciones];

									$Query = mysqli_query($db, "UPDATE Bodega.TIPO_MONTAJE SET TM_NOMBRE = '".$Nombre."', TM_ESTADO = ".$Estado." WHERE TM_CODIGO = ".$Codigo);

									//Loop para recorrer todos los archivos
			                        for($i=0; $i<count($_FILES['Fotografia']['name']); $i++) 
			                        {
			                            //Obtener el nombre temporal del archivo
			                            $tmpFilePath = $_FILES['Fotografia']['tmp_name'][$i];

			                            //Asegurarse que existe el nombre temporal
			                            if ($tmpFilePath != "")
			                            {
			                                //Bloque de código para darle surir el archivo
			                                //Bloque para saber la extensión del archivo
			                                $archivo = basename( $_FILES['Fotografia']['name'][$i]); 
			                                $trozos = explode(".", $archivo); 
			                                $extension = end($trozos);    

			                                //Darle la ruta y el nombre al archivo a guardar
			                                $newFilePath = "Images/";
			                                $newFilePath = $newFilePath . uniqid('file_') . '.' . $extension;

			                                //Subir el Archivo
			                                if(move_uploaded_file($tmpFilePath, $newFilePath)) //Comprobar si no existe un error en la subida
			                                {
			                                    $TipoFotografia = 2;

			                                    //Query para almacenar el path del archivo que se acaba de subir en la base de datos
			                                    $sql = mysqli_query($db, "INSERT INTO Bodega.FOTOGRAFIA_TIPO_MONTAJE (TM_REFERENCIA, FTM_RUTA, FTM_OBSERVACIONES) 
			                                                       VALUES ('". $CodigoUnico ."', '". $newFilePath ."', '". $Observaciones[$i] ."')") or die('ERROR 3'.mysqli_error());

			                                    if(!$sql) //Comprobar si existió algún error en la transacción anterior
			                                    {
			                                        $Error = mysqli_error(); //obtener el código del error

			                                        //Desplegar notificación del error
			                                        echo '<div class="alert alert-danger">';
			                                        echo '<h4>';
			                                        echo '<i class="icon fa fa-ban"></i>';
			                                        echo 'Error!';
			                                        echo '</h4>';
			                                        echo 'No se pudo finalizar la transacción';
			                                        die($Error);
			                                        echo '</div>';
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
			                                    echo 'No se pudo finalizar la transacción en los archivos';
			                                    echo '</div>';
			                                }
			                            }
			                        }

									if($Query)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">El Tipo de Montaje se ingresó correctamente.</h2>
											<div class="row">
												<div class="col-lg-12 text-center"><a href="TipoMontaje.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';
									}
									else
									{
										echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h2 class="text-light">Lo sentimos, no se pudo ingresar el Tipo de Montaje.</h2>
											</div>';
										echo mysqli_error($Query);
							
									}
								?>
							</div> 
						</div>
					</div>
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
	<!-- END JAVASCRIPT -->

	</body>
	</html>
