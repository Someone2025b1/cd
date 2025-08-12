<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Nombre = $_POST["Nombre"];
$Orden = $_POST["Orden"];
$Path = $_POST["Path"];
$Menu = $_POST["Menu"];


$Sql_Datos_SubMenu = mysqli_query($db, $portal_coosajo_db, "INSERT INTO portal_coosajo_db.SUBMENU_APLICATIVO(MA_CODIGO, SMA_NOMBRE, SMA_PATH, SMA_ORDEN, SMA_ESTADO)VALUE(".$Menu.", '".$Nombre."', '".$Path."', ".$Orden.", 1)");

if($Sql_Datos_SubMenu)
{
	echo 1;
}
else
{
	echo 0;
}
?>