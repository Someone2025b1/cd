<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$dato        = $_POST["dato"]; 
$nombreHotel = $_POST["nombreHotel"]; 
$IdCorte          = $_POST["IdCorte"];
$contador    = count($dato);
$Factura     = $_POST["Factura"];

$Insert = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_FAC_HOTEL (CH_Id, H_CODIGO, DC_Fecha) VALUES ($IdCorte, $nombreHotel, CURRENT_TIMESTAMP)");
$IdDetalle = mysqli_insert_id($db);

for ($i=0; $i < $contador; $i++)
{ 
   $SelectVale = mysqli_fetch_array(mysqli_query($db, "SELECT a.IH_ADULTOS, a.IH_NINOS, a.IH_ADULTO_MAYOR, a.IH_TOTAL_ADULTO, a.IH_TOTAL_ADULTO_MAYOR, a.IH_TOTAL_NINO FROM Taquilla.INGRESO_HOTEL a WHERE a.IH_VALE = $dato[$i]"));
   $Insert1 = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_VALE_FACTURA (DVF_Vale, DVF_Hotel, DC_Id) VALUES ($dato[$i], $nombreHotel, $IdDetalle)");
   $Adultos += $SelectVale["IH_ADULTOS"];
   $AdultosM += $SelectVale["IH_ADULTO_MAYOR"];
   $Nino += $SelectVale["IH_NINOS"];
   $TAdultos += $SelectVale["IH_TOTAL_ADULTO"];
   $TAdultosM += $SelectVale["IH_TOTAL_ADULTO_MAYOR"];
   $TNino += $SelectVale["IH_TOTAL_NINO"];
}
 
$TotalAdulto = $Adultos;
$TotalAdultoM = $AdultosM;
$TotalNino = $Nino;
$TotAdulto = $TAdultos;
$TotAdultoM = $TAdultosM+$TotAdultoM;
$TotNino = $TNino;
$Total = $TotNino + $TotAdulto +$TotAdultoM;
$Rango = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(a.DVF_Vale) AS Mayor, MIN(a.DVF_Vale) AS Minimo
FROM Taquilla.DETALLE_VALE_FACTURA a WHERE a.DC_Id = $IdDetalle"));
$Upd = mysqli_query($db, "UPDATE Taquilla.DETALLE_FAC_HOTEL SET DC_Del = $Rango[Minimo],  DC_Al = $Rango[Mayor], DC_Total = $contador, DC_Adultos = $TotalAdulto, DC_TotalAdulto = $TotAdulto, DC_AdultosM = $TotalAdultoM, DC_TotalAdultoM = $TotAdultoM, DC_Ninos = $TotalNino, DC_TotalNino = $TotNino, DC_TotalMonto = $Total WHERE DC_Id = $IdDetalle");

if ($Upd && $Insert) {
    echo "1";
}

?>
