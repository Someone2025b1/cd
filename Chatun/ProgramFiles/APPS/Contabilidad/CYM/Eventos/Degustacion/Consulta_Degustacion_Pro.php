<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/PHPMailer/PHPMailerAutoload.php");
include("../../../../../libs/PHPMailer/class.phpmailer.php");
include("../../../../../libs/PHPMailer/class.smtp.php");

$id_user = $_SESSION["iduser"];

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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.bootstrap.css">

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="card">
				<div class="card-body">
					<?php
						$CodigoUnico                 = $_POST[Codigo];
						$Fecha                       = $_POST[Fecha];
						$HoraInicio                  = $_POST[HoraInicio];
						
						$CUI                         = $_POST[CUI];
						$NIT                         = $_POST[NIT];
						$Nombre                      = $_POST[Nombre];
						$Direccion                   = $_POST[Direccion];
						$Celular                     = $_POST[Celular];
						$Telefono                    = $_POST[Telefono];
						$Email                       = $_POST[Email];
						$CodigoCliente               = $_POST[CodigoCliente];
						
						$Receta                      = $_POST[Receta];
						$Precio                      = $_POST[Precio];
						$Cantidad                    = $_POST[Cantidad];
						$SubTotal                    = $_POST[SubTotal];
						$Descuento                   = $_POST[Descuento];
						$Contador                    = count($Receta);
						
						$EnvioEmail                  = $_POST[EnvioEmail];


						$QueryExisteCliente = mysqli_query($db, "SELECT CE_CODIGO FROM Bodega.CLIENTE_EVENTO WHERE CE_CODIGO = ".$CodigoCliente)or die('Error 1'.mysqli_error());
						$RegistroExisteCliente = mysqli_num_rows($QueryExisteCliente);

						if($RegistroExisteCliente > 0)
						{
							$QueryUpdateCliente = mysqli_query($db, "UPDATE Bodega.CLIENTE_EVENTO SET CE_NOMBRE = '".$Nombre."',
																								CE_DIRECCION = '".$Direccion."',
																								CE_CELULAR = ".$Celular.",
																								CE_TELEFONO = ".$Telefono.",
																								CE_EMAIL = '".$Email."'
																								WHERE CE_CODIGO = ".$CodigoCliente)or die('Error 2'.mysqli_error());
						}
						else
						{
							$QueryInsertCliente = mysqli_query($db, "INSERT INTO Bodega.CLIENTE_EVENTO(CE_CUI, CE_NIT, CE_NOMBRE, CE_DIRECCION, CE_CELULAR, CE_TELEFONO, CE_EMAIL)VALUES('".$CUI."', '".$NIT."', '".$Nombre."', '".$Direccion."', ".$Celular.", ".$Telefono.", '".$Email."')")or die('Error 3'.mysqli_error());
						}


							$Query = mysqli_query($db, "UPDATE Bodega.DEGUSTACION SET D_FECHA = '".$Fecha."',
																			D_HORA = '".$HoraInicio."',
																			CE_CODIGO            = '".$CodigoCliente."',
																			D_CUI               = '".$CUI."',
																			D_NIT               = '".$NIT."',
																			D_NOMBRE            = '".$Nombre."',
																			D_DIRECCION         = '".$Direccion."',
																			D_CELULAR           = '".$Dlular."',
																			D_TELEFONO          = '".$Telefono."',
																			D_EMAIL             = '".$Email."'
																			WHERE D_REFERENCIA   = '".$CodigoUnico."'")or die('Error 4'.mysqli_error());

						$QueryDelete = mysqli_query($db, "DELETE FROM Bodega.PLATILLO_DEGUSTACION WHERE D_REFERENCIA = '".$CodigoUnico."'");

						for ($i=1; $i <= $Contador ; $i++)
						{
							$CodigoPlatillo = uniqid();

							if($Receta[$i-1] != '' && $Cantidad[$i] != '')
							{
								$QueryPlatillo = mysqli_query($db, "INSERT INTO Bodega.PLATILLO_DEGUSTACION(PD_CODIGO, D_REFERENCIA, RS_CODIGO, PD_CANTIDAD)VALUES('".$CodigoPlatillo."', '".$CodigoUnico."', '".$Receta[$i-1]."', ".$Cantidad[$i].")")or die('Error 5'.mysqli_error());
							}
						}

						if($EnvioEmail == 1)
						{
							 $mail = new PHPMailer;

			                $mail->isSMTP();

			                $Fecha = date('d-m-Y');

			                $mail->addAddress($Email, ''); // Correo Destino

			                $mail->Subject = utf8_encode('Degustación en Chatun'); // Asunto

			                $Contenido = '<h1 style="color: #5e9ca0;"><span style="color: #008000;">Buen d&iacute;a Sr(a). '.$Nombre.'!</span></h1>
<h3 style="color: #2e6c80;">Es un gusto poder saludarle, le recordamos que el d&iacute;a '.date("d-m-Y", strtotime($Fecha)).' a las '.$HoraInicio.' tenemos reservada su degustaci&oacute;n.</h3>';

			 

			                $mail->msgHTML($Contenido, __DIR__); // Correo en html

			                if (!$mail->send()) {

			                    echo "Error de Envio: " . $mail->ErrorInfo;

			                }
						}
					?>
					<div class="col-lg-12 text-center">
						<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
						<h2 class="text-light">La degustación se modificó correctamente.</h2>
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
		<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.js"></script>
		<script src="../../../../../js/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="../../../../../js/libs/carousel/dist/carousel.js"></script>
		<script src="../../../../../js/libs/carousel/src/lib/bane/bane.js"></script>
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
	</html>
