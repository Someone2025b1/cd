<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$nombreHotel = $_POST["nombreHotel"];
$adultos     = $_POST["adultos"];
$cantNinos 	 = $_POST["cantNinos"];
$cantMen     = $_POST["cantMen"];
$fechaHotel  = $_POST["fechaHotel"];
$vale  = $_POST["vale"];
$id_user = $_SESSION["iduser"];

$PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));
$TotalAdulto = $adultos * $PrecioAdulto["Precio"];
$TotalNino = $cantNinos * $PrecioNino["Precio"];
$Total = $TotalNino + $TotalAdulto;


$insert = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_HOTEL(H_CODIGO, IH_ADULTOS, IH_NINOS, IH_MENORES_5, IH_VALE, IH_FECHA, IH_COLABORADOR, IH_PRECIO_ADULTO, IH_PRECIO_NINO, IH_TOTAL_ADULTO, IH_TOTAL_NINO, IH_TOTAL)
VALUES('$nombreHotel', $adultos, $cantNinos, $cantMen, $vale, '$fechaHotel', $id_user, $PrecioAdulto[Precio], $PrecioNino[Precio], $TotalAdulto, $TotalNino, $Total)");
$Up = mysqli_query($db, "UPDATE Taquilla.DETALLE_ASIGNACION_VALE SET DAV_ESTADO = 2 where DAV_VALE = $vale AND H_CODIGO = $nombreHotel");

if($insert){
    echo "1";
}
?>