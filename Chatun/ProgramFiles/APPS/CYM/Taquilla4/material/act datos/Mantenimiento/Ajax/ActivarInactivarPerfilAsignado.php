<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Perfil = $_POST["Perfil"];

$Sql_Activa_Inactiva = mysqli_query($db, $portal_coosajo_db, "DELETE FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR WHERE PAC_CODIGO = ".$Perfil);


if($Sql_Activa_Inactiva)
{
	echo 1;
}
else
{
	echo 0;
}

?>