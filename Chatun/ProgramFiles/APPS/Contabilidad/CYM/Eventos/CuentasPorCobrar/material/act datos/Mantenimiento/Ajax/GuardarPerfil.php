<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Nombre = $_POST["Nombre"];
$Descripcion = $_POST["Descripcion"];
$AplicativoPerfil = $_POST["AplicativoPerfil"];


$Sql_Datos_Perfil = mysqli_query($db, $portal_coosajo_db, "INSERT INTO portal_coosajo_db.PRIVILEGIO_APLICATIVO(A_REFERENCIA, PA_NOMBRE, PA_DESCRIPCION, PA_ESTADO)VALUE('".$AplicativoPerfil."', '".$Nombre."', '".$Descripcion."', 1)");

if($Sql_Datos_Perfil)
{
	echo 1;
}
else
{
	echo 0;
}
?>