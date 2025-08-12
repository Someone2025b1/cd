<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Acceso       = $_POST["Acceso"];
$CodigoPerfil = $_POST["CodigoPerfil"];
$Tipo         = $_POST["Tipo"];

if($Tipo == 1)
{
	$Sql_Activa_Inactiva = mysqli_query($db, $portal_coosajo_db, "INSERT INTO portal_coosajo_db.PERMISO_PRIVILEGIO(PA_CODIGO, SM_CODIGO) VALUES (".$CodigoPerfil.", ".$Acceso.")");	
}
else
{
	$Sql_Activa_Inactiva = mysqli_query($db, $portal_coosajo_db, "DELETE FROM portal_coosajo_db.PERMISO_PRIVILEGIO WHERE PA_CODIGO = ".$CodigoPerfil." AND SM_CODIGO = ".$Acceso);
}


if($Sql_Activa_Inactiva)
{
	echo 1;
}
else
{
	echo 0;
}

?>