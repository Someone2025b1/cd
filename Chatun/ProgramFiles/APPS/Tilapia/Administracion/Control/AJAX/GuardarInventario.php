<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha         = $_POST['Fecha'];
$FechaAnt      = date("Y-m-d",strtotime($Fecha."- 1 days"));
$NoEstanque    = $_POST["NoEstanque"]; 
$Id = mysqli_fetch_array(mysqli_query($db, "SELECT a.Id, a.UnidadesTerminadas, a.LibrasTerminadas FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$NoEstanque'"));
$IdControl = $Id["Id"];
$UniTerminadas = $Id["UnidadesTerminadas"];
$LibrasTerminadas = $Id["LibrasTerminadas"];
 
$Observaciones = $_POST["Observaciones"]; 
$Tamanio         = $_POST["Tamanio"];
$Oxigeno         = $_POST["Oxigeno"];
$Ph              = $_POST["Ph"];
$Temperatura     = $_POST["Temperatura"];
$Amonio          = $_POST["Amonio"];
$Peso            = $_POST["Peso"];
$Talla           = $_POST["Talla"];

$PromedioLibra = $LibrasTerminadas / $UniTerminadas;
$CostoTerminado = $UniTerminadas * $CostoAnterior;
$TotalTraslado = $_POST["TotalTraslado"];
$TotalMortalidad = $_POST["TotalMortalidad"];
$TotalPeso = $_POST["TotalPeso"];
$TotalTalla = $_POST["TotalTalla"];
$TotalMuestreo = 1000 / $Tamanio;

 
$IdAlimento    = $_POST["IdAlimento"]; 
$ContAlimentos = count($IdAlimento);
for ($i=0; $i < $ContAlimentos; $i++) { 
$Alimento      = $_POST["Alimento"];
$SQL_INSERT_ALIMENTACION = mysqli_query($db, "INSERT INTO Bodega.ALIMENTACION_PECES (IdControl, TipoAlimento, CantidadLibras, Costo) 
VALUES ('$IdControl', '$IdAlimento[$i]', '$Alimento[$i]', '$CostoAlimento')");
}

$UniTraslado   = $_POST["UniTraslado"];
$ContTraslado = count($UniTraslado);
for ($i=0; $i < $ContTraslado; $i++) {  
$TipoTraslado  = $_POST["TipoTraslado"];
$EstanqueTraslado = $_POST["EstanqueTraslado"];
$SQL_INSERT_TRASLADO = mysqli_query($db, "INSERT INTO Bodega.TRASLADOS_PECES (IdControl, Unidades, TipoTraslado, IdEstanque) 
VALUES ('$IdControl', '$UniTraslado[$i]', '$TipoTraslado[$i]', '$EstanqueTraslado[$i]')");
}

$UniMortalidad  = $_POST["UniMortalidad"];
$ContMuerte 	= count($UniMortalidad);
for ($i=0; $i < $ContMuerte; $i++) {  
$Peso 			= $_POST["Peso"];
$Talla 			= $_POST["Talla"];
$Causa 			= $_POST["Causa"];
$SQL_INSERT_MORTALIDAD = mysqli_query($db, "INSERT INTO Bodega.MORTALIDAD_PECES (Unidades, Peso, Talla, Causa, IdControl) 
VALUES ('$UniMortalidad[$i]', '$Peso[$i]', '$Talla[$i]', '$Causa[$i]', $IdControl)");
}

$filename = $_FILES['file']['name'];
 
 
$AnioActual = date('Y');
$MesActual 	= date('m');
$carpeta_anual = '../Fotografia/'.$AnioActual; 

if (!file_exists($carpeta_anual)) 
{ 
	mkdir($carpeta_anual, 0777, true);
} 
	//////////// CREAR CARPETAS POR DEPARTAMENTOS //////////////////
 $carpeta_mensual = '../Fotografia/'.$AnioActual.'/'.$MesActual;	  
if (!file_exists($carpeta_mensual)) 
{  
	mkdir($carpeta_mensual,  0777, true);
} 
	  	
$return1 = Array('ok'=>TRUE);
$upload_folder  = $carpeta_mensual; 
$archivador     = $upload_folder."/".$filename;
$archivoBBDD = $filename;
 
if(copy($_FILES["file"]["tmp_name"], $archivador))
{ //Copio el archivo de la carpeta temporal a la ubicación.
   $SQL_INSERT_ARCH = mysqli_query($db, "INSERT INTO Bodega.ARCHIVOS_MORTALIDAD (IdControl, Nombre) 
   VALUES ('$CapacidadEstanque', '1', '$Metros', '$Observaciones', CURRENT_TIME, '$id_user')"); 
}
 

$TipoMedicamento = $_POST["TipoMedicamento"];
$CountMed 		 = count($TipoMedicamento);
for ($i=0; $i < $CountMed; $i++) {  
$Cantidad        = $_POST["Cantidad"];
$SQL_INSERT_MED = mysqli_query($db, "INSERT INTO Bodega.MEDICAMENTOS_APLICADOS (IdControl, IdProducto, Cantidad) 
VALUES ('$IdControl', '$TipoMedicamento[$i]', '$Cantidad[$i]')");
}

if ($Peso > 0) 
{
	$PesoF = $Peso;  
}
elseif ($TotalPeso> 0) 
{
	 $PesoF = $TotalPeso; 
}
else 
{
	$PesoAnterior = mysqli_fetch_array(mysqli_query($db, "SELECT a.PesoMuestra FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$FechaAnt' AND a.Estanque = '$NoEstanque'"));
	$PesoF = $PesoAnterior["PesoMuestra"];
}

if ($Talla > 0) 
{
	$TallaF = $Talla;
}
elseif ($TotalTalla> 0) 
{
	$TallaF = $TotalTalla;
}
else 
{
	$TallaAnterior = mysqli_fetch_array(mysqli_query($db, "SELECT a.TallaMuestra FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$FechaAnt' AND a.Estanque = '$NoEstanque'"));
	$TallaF = $TallaAnterior["TallaMuestra"];
}

$SQL_INSERT_CONTROL = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET  Observaciones = '$Observaciones', PromedioLibra = '$PromedioLibra', CostoTerminado = '$CostoTerminado', UnidadesTraslado = '$TotalTraslado', UnidadesMortalidad = '$TotalMortalidad', PesoMortalidad = '$TotalPeso', TallaMortalidad = '$TotalTalla', TamanioMuestra = '$Tamanio', TotalMuestra = '$TotalMuestreo', Oxigeno = '$Oxigeno', PH = '$Ph', Temperatura = '$Temperatura', Amonio = '$Amonio', PesoMuestra = '$PesoF', TallaMuestra = '$TallaF', Colaborador = $id_user, FechaIngreso = CURRENT_TIMESTAMP WHERE Fecha = '$Fecha' and Estanque = $NoEstanque");

if($SQL_INSERT_CONTROL){

	echo '1';
}else {

	echo '2';
}

?>	