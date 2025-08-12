<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$AplicativoMenuEditar = $_POST["AplicativoMenuEditar"];
$CodigoMenuEditar = $_POST["CodigoMenuEditar"];
$NombreEditar = $_POST["NombreEditar"];
$IconoEditar = $_POST["IconoEditar"];
$OrdenEditar = $_POST["OrdenEditar"];
$DepartamentoEditar = $_POST["DepartamentoEditar"];

$Sql_Datos_Menu = mysqli_query($db, $portal_coosajo_db, "UPDATE portal_coosajo_db.MENU_APLICATIVO
                                                            SET MA_NOMBRE = '".$NombreEditar."', 
                                                                MA_ORDEN_MENU = ".$OrdenEditar.",
                                                                MA_ICONO_MENU = '".$IconoEditar."',
                                                                MA_DEPARTAMENTO = ".$DepartamentoEditar."
                                                    WHERE MA_CODIGO = ".$CodigoMenuEditar);
if($Sql_Datos_Menu)
{
    echo 1;
}
else
{
    echo 0;
}

?>