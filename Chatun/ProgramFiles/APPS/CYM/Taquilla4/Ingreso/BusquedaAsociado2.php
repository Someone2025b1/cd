<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Criterio = $_POST['Criterio'];

$params = array();
$options =  array( 'Scrollable' => SQLSRV_CURSOR_KEYSET );

$prestamo1 = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT  CIFNOMBRECLIE, CIFCODCLIENTE,  CIFDOCIDENT02, CIFSEXO, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFCODCLIENTE = ''".$Criterio."''')", $params, $options) or die("error en buscar cif en condiciones diarias");

$prestamo = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT  CIFNOMBRECLIE, CIFCODCLIENTE,  CIFDOCIDENT02, CIFSEXO, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFCODCLIENTE = ''".$Criterio."''')") or die("error en buscar cif en condiciones diarias");

if(sqlsrv_num_rows($prestamo1) < 1)
{
	$prestamo = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT  CIFNOMBRECLIE, CIFCODCLIENTE,  CIFDOCIDENT02, CIFSEXO, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFDOCIDENT06 = ''".$Criterio."''')");
 	$prestamo2 = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT  CIFNOMBRECLIE, CIFCODCLIENTE,  CIFDOCIDENT02, CIFSEXO, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFDOCIDENT06 = ''".$Criterio."''')", $params, $options);

	if(sqlsrv_num_rows($prestamo2) == 0)
	{
  		
  		echo "ERROR NO ENCONTRADO";
	}
	else
	{
		$prestamo_result = sqlsrv_fetch_array($prestamo);
		$CIF = $prestamo_result['CIFCODCLIENTE'];
		$Nombre = $prestamo_result['CIFNOMBRECLIE'];
		$NIT = $prestamo_result['CIFDOCIDENT02'];
		$DPI = $prestamo_result['CIFDOCIDENT06'];
		$Pasaporte = $prestamo_result['CIFDOCIDENT03'];
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
	$prestamo_result = sqlsrv_fetch_array($prestamo);

	$CIF = $prestamo_result['CIFCODCLIENTE'];
	$Nombre = $prestamo_result['CIFNOMBRECLIE'];
	$NIT = $prestamo_result['CIFDOCIDENT02'];
	$DPI = $prestamo_result['CIFDOCIDENT06'];
	$Pasaporte = $prestamo_result['CIFDOCIDENT03'];
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

?>
