<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


$CodigoColaborador = $_POST['CodigoEmpleado'];
$NombresFamiliar = $_POST['NombresFamiliar'];
$ApellidosFamiliar = $_POST['ApellidosFamiliar'];
$CelFamiliar = $_POST['CelFamiliar'];
$Parentersco = $_POST['Parentersco'];
$CodFam        = uniqid("Fam_");
$Actualizar = 0;




			$consulta = "SELECT * FROM RRHH.FAMILIAR_COLABORADOR WHERE C_CODIGO = '".$CodigoColaborador."' AND FC_PARENTESCO = '".$Parentersco."'";
				$result = mysqli_query($db,$consulta);
				while($fila = mysqli_fetch_array($result))
				{
					$Actualizar = 1;
				}


				if($Actualizar==1){

					$sqlDocumento = mysqli_query($db, "UPDATE  RRHH.FAMILIAR_COLABORADOR SET
								FC_NOMBRES = '$NombresFamiliar',
								FC_APELLIDOS = '$ApellidosFamiliar',
								FC_CELULAR = '$CelFamiliar'
								WHERE FC_PARENTESCO = '".$Parentersco."'
								AND C_CODIGO ='".$CodigoColaborador."'");

				}else{

				

					$sqlDocumento = mysqli_query($db, "INSERT INTO RRHH.FAMILIAR_COLABORADOR (C_CODIGO, FC_CODIGO, FC_NOMBRES, FC_APELLIDOS,
					FC_PARENTESCO, FC_CELULAR, FC_OTRO)
					VALUES('$CodigoColaborador', '$CodFam', '$NombresFamiliar', '$ApellidosFamiliar',
					'$Parentersco', '$CelFamiliar', 0)");
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
								<h4 class="text-center"><strong>Familiar Guardado</strong></h4>
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
