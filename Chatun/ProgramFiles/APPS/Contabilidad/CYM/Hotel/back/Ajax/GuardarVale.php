<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$dato        = $_POST["dato"]; 
$nombreHotel = $_POST["nombreHotel"]; 
$IdCorte          = $_POST["IdCorte"];
$contador    = count($dato);
$Factura     = $_POST["Factura"];

$Insert = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_CORTE (CH_Id, H_CODIGO, DC_Factura, DC_Fecha) VALUES ($IdCorte, $nombreHotel, $Factura, CURRENT_TIMESTAMP)");
$IdDetalle = mysqli_insert_id($db);

for ($i=0; $i < $contador; $i++)
{ 
   $SelectVale = mysqli_fetch_array(mysqli_query($db, "SELECT a.IH_ADULTOS, a.IH_NINOS FROM Taquilla.INGRESO_HOTEL a WHERE a.IH_VALE = $dato[$i]"));
   $Insert1 = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_VALE_FACTURA (DVF_Vale, DVF_Hotel, DC_Id) VALUES ($dato[$i], $nombreHotel, $IdDetalle)");
   $Adultos += $SelectVale["IH_ADULTOS"];
   $Nino += $SelectVale["IH_NINOS"];
}

$PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));
$TotalAdulto = $Adultos * $PrecioAdulto["Precio"];
$TotalNino = $Nino * $PrecioNino["Precio"];
$Total = $TotalNino + $TotalAdulto;
$Rango = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(a.DVF_Vale) AS Mayor, MIN(a.DVF_Vale) AS Minimo
FROM Taquilla.DETALLE_VALE_FACTURA a WHERE a.DC_Id = $IdDetalle"));
$Upd = mysqli_query($db, "UPDATE Taquilla.DETALLE_CORTE SET DC_Del = $Rango[Minimo],  DC_Al = $Rango[Mayor], DC_Total = $contador, DC_Adultos = $Adultos, DC_TotalAdulto = $TotalAdulto, DC_Ninos = $Nino, DC_TotalNino = $TotalNino, DC_TotalMonto = $Total WHERE DC_Id = $IdDetalle");

if ($Upd && $Insert) {
    echo "1";
}

?>
