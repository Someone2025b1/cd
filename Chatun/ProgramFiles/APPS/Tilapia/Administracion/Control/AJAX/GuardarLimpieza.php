<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha = $_POST['Fecha'];
$NoEstanque = $_POST["NoEstanque"];  
$UniTerminadas = $_POST["UniTerminadas"];
$LibrasTerminadas = $_POST["LibrasTerminadas"];
$Observaciones = $_POST["Observaciones"];
$UnidadesDa = $_POST["UnidadesDa"];
$LibrasDa = $_POST["LibrasDa"];
$CausaDa = $_POST["CausaDa"];
$TotalidadDa = $_POST["TotalidadDa"];
$TotalidadDaLibr = $_POST["TotalidadDaLibr"];
$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.LIMPIEZA_TILAPIA (Fecha, Unidades, Libras, Observaciones, Colaborador, FechaIngreso) 
VALUES ('$Fecha', $UniTerminadas, $LibrasTerminadas, '$Observaciones', $id_user, CURRENT_TIMESTAMP)");
$IdLimp = mysqli_insert_id($db);  
$Unidades = $_POST["Unidades"];
$Causa = $_POST["Causa"];

$Cont1 = count($UnidadesDa);
if ($Cont1) {
	 $SQL_DIF = mysqli_query($db, "INSERT INTO Bodega.PRODUCTOS_DANIADOS (Cantidad, Libras, Fecha, Colaborador, IdLimpieza) 
VALUES ('$TotalidadDa', '$TotalidadDaLibr', '$Fecha', '$id_user', $IdLimp)");
	 $IdD = mysqli_insert_id($db);
	 for ($i=0; $i < $Cont1; $i++) { 
	 	 $SQL_DIF2 = mysqli_query($db, "INSERT INTO Bodega.DETALLE_PROD_DANIADOS (IdProDaniado, Cantidad, Libras, Explicacion) 
VALUES ($IdD, $UnidadesDa[$i], $LibrasDa[$i], '$CausaDa[$i]')");
	 }
}

$Cont = count($Unidades);
if ($Cont) {
	 $SQL_DIF = mysqli_query($db, "INSERT INTO Bodega.DIFERENCIA_PROD_LIMPIEZA (Fecha, Unidades, Libras, Colaborador) 
VALUES ('$Fecha','$UniTerminadas', '$LibrasTerminadas', $id_user)");
	 $Id = mysqli_insert_id($db);
	 for ($i=0; $i < $Cont; $i++) { 
	 	 $SQL_DIF2 = mysqli_query($db, "INSERT INTO Bodega.DETALLE_DIFERENCIA (IdDiferencia, Unidades, Explicacion) 
VALUES ($Id, $Unidades[$i], '$Causa[$i]')");
	 }
}

  
if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	