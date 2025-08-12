<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Perfil = $_POST["Perfil"];
$Tipo = $_POST["Tipo"];

if($Tipo == 1)
{
	$Estado = 1;
}
else
{
	$Estado = 2;
}

$Sql_Activa_Inactiva = mysqli_query($db, $portal_coosajo_db, "UPDATE portal_coosajo_db.PRIVILEGIO_APLICATIVO SET PA_ESTADO = ".$Estado." WHERE PA_CODIGO = ".$Perfil);


if($Sql_Activa_Inactiva)
{
	echo 1;
}
else
{
	echo 0;
}

?>