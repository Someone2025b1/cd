<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$Query = mysqli_query($db, "SELECT *
						FROM Bodega.CLIENTE_EVENTO AS A
						WHERE A.CE_CUI = '".$Codigo."'");

$Registros = mysqli_num_rows($Query);


if($Registros > 0)
{
	$Fila = mysqli_fetch_array($Query);

	$Data = array('nit'=> $Fila[CE_NIT], 'nombre'=> $Fila[CE_NOMBRE], 'direccion'=> $Fila[CE_DIRECCION], 'celular'=> $Fila[CE_CELULAR], 'telefono'=> $Fila[CE_TELEFONO], 'email'=> $Fila[CE_EMAIL], 'codigo'=> $Fila[CE_CODIGO]);

	$json_string = json_encode($Data);
    echo $json_string;
}
else
{
	echo 0;
}

?>