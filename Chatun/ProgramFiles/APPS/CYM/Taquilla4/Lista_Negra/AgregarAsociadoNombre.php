<?php 
include("../../../../../Script/seguridad.php");
//include("../../../../../Script/conex.php");
include("../../../../../Script/conex_213.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Criterio = $_POST['Criterio'];

$prestamo = mysqli_query($db, "SELECT cifcodcliente,  cifdocident02, cifsexo, cifdocident06, cifdocident03  FROM bankworks.cif_generales WHERE cifcodcliente = '$Criterio'"_213) or die("error en buscar cif en condiciones diarias".mysqli_error());

if(mysqli_num_rows($prestamo) < 1)
{
	$prestamo = mysqli_query($db, "SELECT cifcodcliente,  cifdocident02, cifsexo, cifdocident06, cifdocident03  FROM bankworks.cif_generales WHERE cifdocident06 = '$Criterio'"_213);




	if(mysqli_num_rows($prestamo) == 0)
	{
		echo 'ERROR_NO_ENCONTRADO';
	}
	else
	{
		$prestamo_result = mysqli_fetch_array($prestamo);
		$CIF = $prestamo_result['cifcodcliente'];
		$Nombre = saber_nombre_asociado_orden($CIF);
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

		$Genero = $prestamo_result['cifsexo'];

		echo '<div class="hbox-column style-default-light">
		<div class="row">
			<input type="hidden" name="CIF" id="CIF" value="'.$CIF.'">
			<div class="col-xs-12">
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
			</div><!--end .col -->
		</div><!--end .row -->
	</div>';
}


}
else
{
	$prestamo_result = mysqli_fetch_array($prestamo);

	$CIF = $prestamo_result['cifcodcliente'];
	$Nombre = saber_nombre_asociado_orden($CIF);
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

	$Genero = $prestamo_result['cifsexo'];

	echo '<div class="hbox-column style-default-light">
	<div class="row">
		<input type="hidden" name="CIF" id="CIF" value="'.$CIF.'">
		<div class="col-xs-12">
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
			<div class="col-lg-6">
				<dl class="dl-horizontal dl-icon">
					<dd>
						<span class="opacity-50"><b>Documento de Identificación</b></span><br>
						<span class="text-medium">'.$Identificacion.'</span>
					</dd>
				</dl><!--end .dl-horizontal -->
			</div>
		</div><!--end .col -->
	</div><!--end .row -->
</div>';											
}

?>
