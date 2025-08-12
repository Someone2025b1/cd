<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoSubMenuEditar = $_POST["CodigoSubMenuEditar"];
$MenuEditar = $_POST["MenuEditar"];
$NombreEditar = $_POST["NombreEditar"];
$PathEditar = $_POST["PathEditar"];
$OrdenEditar = $_POST["OrdenEditar"];

$Sql_Datos_Menu = mysqli_query($db, $portal_coosajo_db, "UPDATE portal_coosajo_db.SUBMENU_APLICATIVO
                                                            SET SMA_NOMBRE = '".$NombreEditar."', 
                                                                MA_CODIGO = ".$MenuEditar.",
                                                                SMA_PATH = '".$PathEditar."',
                                                                SMA_ORDEN = ".$OrdenEditar."
                                                    WHERE SMA_CODIGO = ".$CodigoSubMenuEditar);
if($Sql_Datos_Menu)
{
    echo 1;
}
else
{
    echo 0;
}

?>