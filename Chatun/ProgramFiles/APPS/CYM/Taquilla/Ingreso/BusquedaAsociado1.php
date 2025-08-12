<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Criterio = $_POST['Criterio'];
 
$prestamo = mysqli_query($dbc, "SELECT a.cifcodcliente, a.cifdocident02, a.cifsexo, a.cifdocident06, a.cifdocident03 FROM bankworks.cif_generales a WHERE a.cifcodcliente = $Criterio");

if(mysqli_num_rows($prestamo) < 1)
{ 
	$prestamo = mysqli_query($dbc, "SELECT a.cifcodcliente, a.cifdocident02, a.cifsexo, a.cifdocident06, a.cifdocident03 FROM bankworks.cif_generales a WHERE a.cifdocident06 = $Criterio");

 
	if(mysqli_num_rows($prestamo) == 0)
	{
		echo 'ERROR_NO_ENCONTRADO';
	}
	else
	{
		$prestamo_result = mysqli_fetch_array($prestamo);
		$CIF = $prestamo_result['cifcodcliente'];
		$Nombre = saber_nombre_asociado($CIF);
		$NIT = $prestamo_result['cifdocident02'];
		$DPI = $prestamo_result['cifdocident06'];
		$Pasaporte = $prestamo_result['cifdocident03'];
		if($DPI == '')
		{
			$Identificacion = '<b>Pasaporte</b> '.$Pasaporte;	
		}
		else
		{
			$Identificacion = '<b>DPI</b> '.$DPI;	
		}

		$QueryLN = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA WHERE LN_CIF_ASOCIADO = ".$CIF);
	$RegistrosLN = mysqli_num_rows($QueryLN);

		$Genero = $prestamo_result['cifsexo'];

		echo '<div class="hbox-column style-default-light">
		<div class="row">
			<div class="col-xs-12">
				<h3 class="text-center"><b>Resultado de Búsqueda</b></h3>
				<br>
				<div class="col-lg-1">
					<dl class="dl-horizontal dl-icon">
						<dd>
							<span class="opacity-50"><b>CIF</b></span><br>
							<span class="text-medium">'.$CIF.'</span>
						</dd>
					</dl><!--end .dl-horizontal -->
				</div>
				<div class="col-lg-4">
					<dl class="dl-horizontal dl-icon">
						<dd>
							<span class="opacity-50"><b>Nombre</b></span><br>
							<span class="text-medium">'.$Nombre.'</span>
						</dd>
					</dl><!--end .dl-horizontal -->
				</div>
				<div class="col-lg-2">
					<dl class="dl-horizontal dl-icon">
						<dd>
							<span class="opacity-50"><b>Documento de Identificación</b></span><br>
							<span class="text-medium">'.$Identificacion.'</span>
						</dd>
					</dl><!--end .dl-horizontal -->
				</div>
				<div class="col-lg- text-center">
					<dl class="dl-horizontal dl-icon">
						<dd class="text-center">
							<span class="text-medium">
								<button type="button" data-cif="'.$CIF.'" value="'.$CIF.'" class="btn btn-sm btn-primary" onclick="AgregarAsociado(this.value)">Agregar</button>
							</span>
						</dd>
					</dl><!--end .dl-horizontal -->
				</div>
			</div><!--end .col -->
		</div><!--end .row -->
	</div>';

	if($RegistrosLN > 0)							
	{
		echo '<div class="hbox-column style-default-light text-center">
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<h2><strong>EL ASOCIADO QUE ESTÁ TRATANDO DE INGRESAR ESTÁ EN LA LISTA NEGRA <br><a href="../Lista_Negra/ListaNegra.php">Click Aquí para Consultar</a></strong></h2>
						</div>
					</div>
				</div>';
	}
}


}
else
{
	$prestamoD = mysqli_query($dbc, "SELECT a.cifcodcliente, a.cifdocident02, a.cifsexo, a.cifdocident06, a.cifdocident03 FROM bankworks.cif_generales a WHERE a.cifcodcliente = $Criterio");
	 $prestamo_result1 = mysqli_fetch_array($prestamoD);

	$CIF = $prestamo_result1['cifcodcliente'];
	$Nombre = saber_nombre_asociado($CIF);
	$NIT = $prestamo_result1['cifdocident02'];
	$DPI = $prestamo_result1['cifdocident06'];
	$Pasaporte = $prestamo_result1['cifdocident03'];
	if($DPI == '')
	{
		$Identificacion = '<b>Pasaporte</b> '.$Pasaporte;	
	}
	else
	{
		$Identificacion = '<b>DPI</b> '.$DPI;	
	}

	$QueryLN = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA WHERE LN_CIF_ASOCIADO = ".$CIF);
	$RegistrosLN = mysqli_num_rows($QueryLN);



	$Genero = $prestamo_result1['cifsexo'];

	echo '<div class="hbox-column style-default-light">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="text-center"><b>Resultado de Búsqueda</b></h3>
			<br>
			<div class="col-lg-1">
				<dl class="dl-horizontal dl-icon">
					<dd>
						<span class="opacity-50"><b>CIF</b></span><br>
						<span class="text-medium">'.$CIF.'</span>
					</dd>
				</dl><!--end .dl-horizontal -->
			</div>
			<div class="col-lg-4">
				<dl class="dl-horizontal dl-icon">
					<dd>
						<span class="opacity-50"><b>Nombre</b></span><br>
						<span class="text-medium">'.$Nombre.'</span>
					</dd>
				</dl><!--end .dl-horizontal -->
			</div>
			<div class="col-lg-2">
				<dl class="dl-horizontal dl-icon">
					<dd>
						<span class="opacity-50"><b>Documento de Identificación</b></span><br>
						<span class="text-medium">'.$Identificacion.'</span>
					</dd>
				</dl><!--end .dl-horizontal -->
			</div>
			<div class="col-lg- text-center">
				<dl class="dl-horizontal dl-icon">
					<dd class="text-center">
						<span class="text-medium">
							<button type="button" data-cif="'.$CIF.'" value="'.$CIF.'" class="btn btn-sm btn-primary" onclick="AgregarAsociado(this.value)">Agregar</button>
						</span>
					</dd>
				</dl><!--end .dl-horizontal -->
			</div>
		</div><!--end .col -->
	</div><!--end .row -->
</div>';				
	if($RegistrosLN > 0)							
	{
		echo '<div class="hbox-column style-default-light text-center">
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<h2><strong>EL ASOCIADO QUE ESTÁ TRATANDO DE INGRESAR ESTÁ EN LA LISTA NEGRA <br><a href="../Lista_Negra/ListaNegra.php">Click Aquí para Consultar</a></strong></h2>
						</div>
					</div>
				</div>';
	}
}

?>
