<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


$CodigoColaborador = $_POST['CodigoEmpleado'];
$documento = $_POST['documento'];
$TipoDocumento = $_POST['TipoDocumento'];
$CodDoc        = uniqid("Doc_");
$Actualizar = 0;


if ($_FILES["documento"]["error"] === 0) {

	$permitidos = array("application/pdf");
	$limite_kb = 1024; //1 MB

	if (in_array($_FILES["documento"]["type"], $permitidos) && $_FILES["documento"]["size"] <= $limite_kb * 1024) {

		$ruta = 'files/'.$CodigoColaborador."/";
		$archivoNombre = $_FILES["documento"]["name"];
		$trozos = explode(".", $archivoNombre); 
		$extension = end($trozos);
		$archivo = $ruta .$TipoDocumento."-".$CodigoColaborador.".". $extension;

		if (!file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}

		

			$resultado = move_uploaded_file($_FILES["documento"]["tmp_name"], $archivo);

			if ($resultado) {
				echo "Archivo Guardado";
			} else {
				echo "Error al guardar archivo";
			}
		
	} else {
		echo "Archivo no permitido o excede el tamaño";
	}
}

			$consulta = "SELECT * FROM RRHH.DOCUMENTOS_COLABORADOR WHERE C_CODIGO = '".$CodigoColaborador."' AND DC_TIPO = '".$TipoDocumento."'";
				$result = mysqli_query($db,$consulta);
				while($fila = mysqli_fetch_array($result))
				{
					$Actualizar = 1;
				}


				if($Actualizar==1){

					$sqlDocumento = mysqli_query($db, "UPDATE  RRHH.DOCUMENTOS_COLABORADOR SET
								DC_ARCHIVO = '$extension'
								WHERE DC_TIPO = '".$TipoDocumento."'
								AND C_CODIGO ='".$CodigoColaborador."'");

				}else{

				

					$sqlDocumento = mysqli_query($db, "INSERT INTO RRHH.DOCUMENTOS_COLABORADOR (C_CODIGO, DC_CODIGO, DC_TIPO, DC_ARCHIVO, DC_LUGAR)
														VALUES('$CodigoColaborador', '$CodDoc', '$TipoDocumento', '$extension', 'Docuemento')");
							}

		

		
?>

<script>
		function EnviarFormulario()
		{
			var formulario = document.getElementById("FormularioEnviar");
			formulario.submit();
			return true;
		}
	</script>
<html>
	<head>

	</head>
	<body>
	<div id="content">
			<div class="container">
				<form id="FormularioEnviar" action="EditarColaborador.php?CodigoColaborador=<?php echo $CodigoColaborador ?>" method="POST">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Documetno Guardado</strong></h4>
							</div>
						</div>
					</div>
				</form>
			</div>
	</div>
	</body>
</html>

<script>
					<?php
					if($sqlDocumento){
					?>
									EnviarFormulario();
									<?php
					}
									?>
								</script>
