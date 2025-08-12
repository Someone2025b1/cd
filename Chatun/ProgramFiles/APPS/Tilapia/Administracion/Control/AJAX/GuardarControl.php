<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha         = $_POST['Fecha'];
$FechaAnt      = date("Y-m-d",strtotime($Fecha."- 1 days"));
$NoEstanque    = $_POST["NoEstanque"];
$time=strtotime($Fecha);
$month=date("F",$time);
$year=date("Y",$time);
/* por si quieren insertar las filas para que se vea el registro
if ($Conteo==0) {
	
	$date1 = new DateTime($Fecha);
	$date2 = new DateTime($UltimaFecha["Fecha"]);
	$diff = $date1->diff($date2);
	
	$i = 1;
	while ($i < $diff->days) {
		$UltimaFecha2 = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(A.Fecha) AS Fecha FROM Bodega.CONTROL_PISICULTURA A WHERE A.Estanque  = $NoEstanque"));
		$FechaInsert = date("d-m-Y",strtotime($UltimaFecha2['Fecha']."+ 1 days"));
		 $InsertarFaltantes = mysqli_query($db, "INSERT INTO Bodega.CONTROL_PISICULTURA (Fecha, Estanque, PesoMuestra, TallaMuestra, Existencia, CostoUnitario, CostoTotal)
SELECT DATE(DATE_ADD(A.Fecha, INTERVAL $i DAY)), A.Estanque, A.PesoMuestra, A.TallaMuestra, A.Existencia, A.CostoUnitario, A.CostoTotal FROM Bodega.CONTROL_PISICULTURA A WHERE A.Estanque  = 2 AND A.Fecha = ''$UltimaFecha[Fecha]''");
		 $i++;
	} 
}*/
//Validamos si ya hemos ingresado info anteriormente para validar las cantidades iniciales del estanque
$UltimaFecha = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(A.Fecha) AS Fecha FROM Bodega.CONTROL_PISICULTURA A WHERE A.Estanque  = $NoEstanque"));
$Conteo = mysqli_num_rows(mysqli_query($db, "SELECT * FROM Bodega.CONTROL_PISICULTURA A 
WHERE A.Estanque = $NoEstanque AND A.Fecha = '$UltimaFecha[Fecha]'"));
$CantInicialC = mysqli_fetch_array(mysqli_query($db, "SELECT A.Existencia, A.CostoUnitario, A.CostoTotal FROM Bodega.CONTROL_PISICULTURA A 
	WHERE A.Estanque = $NoEstanque AND A.Fecha = '$UltimaFecha[Fecha]'"));
 
if ($Conteo>0) { 

	$Cant = $CantInicialC["Existencia"];
	$CostT = $CantInicialC["CostoTotal"];
	$CostoAnterior = $CantInicialC["CostoUnitario"];	
}
else
{
	$ConteoInventario = mysqli_num_rows(mysqli_query($db, "SELECT a.CantidadInicial, a.CostoTotal, a.CostoUnitario FROM Bodega.INVENTARIO_INICIAL_PECES a WHERE a.Mes = $month AND a.Anio = $year"));
	if ($ConteoInventario) {
		$Inventario = mysqli_fetch_array(mysqli_query($db, "SELECT a.CantidadInicial, a.CostoTotal, a.CostoUnitario FROM Bodega.INVENTARIO_INICIAL_PECES a WHERE a.Mes = $month AND a.Anio = $year"));
		$Cant = $Inventario["CantidadInicial"];
		$CostT = $Inventario["CostoTotal"];
		$CostoAnterior = $Inventario["CostoUnitario"]; 
	}
	else
	{
	$CantInicial = mysqli_fetch_array(mysqli_query($db, "SELECT A.InventarioInicial, A.CostoTotal, A.CostoUnitario FROM Pisicultura.Estanque A WHERE A.IdEstanque = $NoEstanque"));
	$Cant = $CantInicial["InventarioInicial"];
	$CostT = $CantInicial["CostoTotal"];
	$CostoAnterior = $CantInicial["CostoUnitario"]; 
	}
}

//sino hemos ingresado en produccion insertamos la linea del control de la fecha correspondiente
$Contar = mysqli_num_rows(mysqli_query($db, "SELECT a.Id, a.UnidadesTerminadas, a.LibrasTerminadas FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$NoEstanque'"));
if ($Contar==0) {
 	 $SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.CONTROL_PISICULTURA (Fecha, Estanque) 
	VALUES ('$Fecha', '$NoEstanque')");
 } 
$Id = mysqli_fetch_array(mysqli_query($db, "SELECT a.Id, a.UnidadesTerminadas, a.LibrasTerminadas FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$NoEstanque'"));
$IdControl = $Id["Id"];
$UniTerminadas = $Id["UnidadesTerminadas"];
$LibrasTerminadas = $Id["LibrasTerminadas"];
 //variables recibidas
$Observaciones = $_POST["Observaciones"]; 
$Tamanio         = $_POST["Tamanio"];
$Oxigeno         = $_POST["Oxigeno"];
$Ph              = $_POST["Ph"];
$Temperatura     = $_POST["Temperatura"];
$Amonio          = $_POST["Amonio"];
$Peso            = $_POST["Peso"];
$Talla           = $_POST["Talla"];
//calculos
$PromedioLibra = $LibrasTerminadas / $UniTerminadas;
$CostoTerminado = $UniTerminadas * $CostoAnterior;
 
$TotalMortalidad = $_POST["TotalMortalidad"];
$TotalPeso = $_POST["TotalPeso"];
$TotalTalla = $_POST["TotalTalla"];
$TotalMuestreo = $Cant / $Tamanio;
$IdAlimento    = $_POST["IdAlimento"]; 

//Ingreso de alimentacion
$ContAlimentos = count($IdAlimento);
for ($i=0; $i < $ContAlimentos; $i++) { 
$Alimento      = $_POST["Alimento"];
//Saber Costo de alimentacion
$Precio = mysqli_fetch_array(mysqli_query($db, "SELECT a.Precio FROM Pisicultura.Producto_Pisicultura a WHERE a.IdProducto = $IdAlimento[$i]"));
$PrecioU = $Precio["Precio"];
$CostoA = $PrecioU * $Alimento[$i];
$SQL_INSERT_ALIMENTACION = mysqli_query($db, "INSERT INTO Bodega.ALIMENTACION_PECES (IdControl, TipoAlimento, CantidadLibras, Costo) 
VALUES ('$IdControl', '$IdAlimento[$i]', '$Alimento[$i]', '$CostoA')");
$CostoAlimentacion += $CostoA;
}
//traslado de peces
$UniTraslado   = $_POST["UniTraslado"];
$ContTraslado = count($UniTraslado);
for ($i=0; $i < $ContTraslado; $i++) 
{  
	$TipoTraslado  = $_POST["TipoTraslado"];
	$EstanqueTraslado = $_POST["EstanqueTraslado"][$i];
	//si es una entrada suma el valor con el precio anterior de la tilapia
	if ($TipoTraslado[$i]==1)
	{
		$Unitras = $UniTraslado[$i] * -1;
		$Costeo = mysqli_fetch_array(mysqli_query($db, "SELECT A.CostoUnitario  FROM Bodega.CONTROL_PISICULTURA A 
		WHERE A.Estanque = $EstanqueTraslado AND A.Fecha = '$UltimaFecha[Fecha]'"));
		$CostoU = $Costeo["CostoUnitario"]; 
		$Val = 1;
	}
	else //si es una salida resta al costo del dia e incrementa en el otro estanque
	{ 
		$CostoU = $CostoAnterior * -1;
		$Val = -1;
		$Unitras = $UniTraslado[$i];
		//valido si ya se hizo el control en el estanque a ingresar la tilapia
		$Contar = mysqli_num_rows(mysqli_query($db, "SELECT * FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$EstanqueTraslado'"));
		if ($Contar==0) 
		{
		$ConteoExi = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]' AND a.Estanque = '$EstanqueTraslado'"));
			if ($ConteoExi==0) 
			{
				$CantInicial = mysqli_fetch_array(mysqli_query($db, "SELECT A.InventarioInicial, A.CostoTotal, A.CostoUnitario FROM Pisicultura.Estanque A WHERE A.IdEstanque = $EstanqueTraslado"));
				 $TotalExi = $CantInicial["InventarioInicial"];
			}
			else
			{
				$Total = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]' AND a.Estanque = '$EstanqueTraslado'")); 
				$TotalExi = $Total["Existencia"]; 
			}
			$TotalCos = mysqli_fetch_array(mysqli_query($db, "SELECT a.CostoUnitario, a.CostoTotal FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]' AND a.Estanque = '$NoEstanque'")); 
			$CostoFin = $TotalCos["CostoTotal"];
			$CostoUni = $TotalCos["CostoUnitario"];
			$Exi = $TotalExi + $Unitras;
			$CostoIns = $CostoUni * $Exi;
			
		 	$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.CONTROL_PISICULTURA (Fecha, Estanque, UnidadesTraslado, CostoUTraslado, CostoUTotalTraslado, Existencia, CostoUnitario, CostoTotal) 
			VALUES ('$Fecha', '$EstanqueTraslado', $Unitras, $CostoAnterior, $CostoIns, $Exi, $CostoUni ,$CostoIns)");
		} 
		else
		{
		$Total = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia, a.CostoUnitario, a.CostoTotal, a.UnidadesTraslado, a.CostoUTraslado, a.CostoUTotalTraslado FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]' AND a.Estanque = '$NoEstanque'"));
		$UniT = $Unitras + $Total["UnidadesTraslado"];
		$CostoUT = $CostoU + $Total["CostoUTraslado"];
		$CostoUTT = $CostoTT + $Total["CostoUTotalTraslado"];
		$ExistenciaT = $Total["Existencia"] + $Unitras; 
		$CostoTF = $Total["CostoTotal"] + ($CostoUnitario * $Unitras);
		$CostoUF = $Total["CostoUnitario"] + ($CostoTF/$ExistenciaT);
		
		$SQL_INSERT_CONTROL = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET UnidadesTraslado = '$UniT', CostoUTraslado = '$CostoUT', CostoUTotalTraslado = '$CostoUTT', Existencia = '$ExistenciaT', CostoUnitario = '$CostoUF', CostoTotal = '$CostoTF' WHERE Fecha = '$Fecha' and Estanque = $EstanqueTraslado");
		}	

	}

	$CostoTotalTraslado = $CostoU * $Unitras;
	$SQL_INSERT_TRASLADO = mysqli_query($db, "INSERT INTO Bodega.TRASLADOS_PECES (IdControl, Unidades, TipoTraslado, CostoUnitario, CostoTotal, IdEstanque) 
	VALUES ('$IdControl', '$Unitras', '$TipoTraslado[$i]', $CostoU, $CostoTotalTraslado, '$EstanqueTraslado[$i]')");
	$CostoTT += $CostoTotalTraslado;
	$TotalTraslado += ($Unitras * $Val);

}
//mortalidad de peces
$UniMortalidad  = $_POST["UniMortalidad"];
$ContMuerte 	= count($UniMortalidad);
for ($i=0; $i < $ContMuerte; $i++) {  
$Peso 			= $_POST["Peso"];
$Talla 			= $_POST["Talla"];
$Causa 			= $_POST["Causa"];
$SQL_INSERT_MORTALIDAD = mysqli_query($db, "INSERT INTO Bodega.MORTALIDAD_PECES (Unidades, Peso, Talla, Causa, IdControl) 
VALUES ('$UniMortalidad[$i]', '$Peso[$i]', '$Talla[$i]', '$Causa[$i]', $IdControl)");
}
//ingreso fotografia peces mortalidad
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
$archivador     = $upload_folder."/".$IdControl."-".$filename;
$archivoBBDD = $filename;
 
if(copy($_FILES["file"]["tmp_name"], $archivador))
{ //Copio el archivo de la carpeta temporal a la ubicación.
	$NameA = $IdControl."-".$archivoBBDD;
   $SQL_INSERT_ARCH = mysqli_query($db, "INSERT INTO Bodega.ARCHIVOS_MORTALIDAD (IdControl, Nombre, Tipo, Fecha) 
   VALUES ('$IdControl', '$NameA',1, '$Fecha')"); 
}
 
//ingreso medicamento
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
elseif ($LibrasTerminadas> 0) 
{ 
	$PesoF = $LibrasTerminadas / $UniTerminadas;
}
else
{
	$PesoAnterior = mysqli_fetch_array(mysqli_query($db, "SELECT a.PesoMuestra FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]'"));
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
	$TallaAnterior = mysqli_fetch_array(mysqli_query($db, "SELECT a.TallaMuestra FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$UltimaFecha[Fecha]' AND a.Estanque = '$NoEstanque'"));
	$TallaF = $TallaAnterior["TallaMuestra"];
}

if ($TotalMortalidad>0 && $CantInicialC["Existencia"]>0) 
{

	 $CostoUMortalidad = $CantInicialC["CostoUnitario"];
	 $CostoTotalMortalidad = $CostoUMortalidad * $TotalMortalidad;
}
elseif ($TotalMortalidad>0 && $CantInicialC["Existencia"]==0) 
{
	$CostoUMortalidad = 0;
	$CostoTotalMortalidad = 0;
}
else 
{
	$CostoUMortalidad = 0;
	$CostoTotalMortalidad = 0;
}

$PecesTraslado = mysqli_num_rows(mysqli_query($db, "SELECT A.Unidades FROM Bodega.TRASLADOS_PECES A 
INNER JOIN Bodega.CONTROL_PISICULTURA B ON A.IdControl = A.IdControl
WHERE A.IdEstanque = $NoEstanque AND B.Fecha = '$Fecha' AND A.TipoTraslado = 2"));
if ($PecesTraslado>0) { 
	$CostosAct = mysqli_fetch_array(mysqli_query($db, "SELECT A.Existencia, A.CostoUnitario, A.CostoTotal FROM Bodega.CONTROL_PISICULTURA A 
	WHERE A.Estanque = $NoEstanque AND A.Fecha = '$Fecha'"));
	$MasPeces = $CostosAct["Existencia"];
	$CostoSumaTrasF = $CostosAct["CostoTotal"];
	$CostoSumaTrasU = $CostosAct["CostoUnitario"];

}
else
{
	$MasPeces = 0;
	$CostoSumaTrasF = 0;
	$CostoSumaTrasU = 0;
}
$CantidadComp = mysqli_fetch_array(mysqli_query($db, "SELECT A.CantidadCompra, A.TotalCompra FROM Bodega.CONTROL_PISICULTURA A WHERE A.Estanque = $NoEstanque and A.Fecha = '$Fecha'"));
$CantCompra = $CantidadComp["CantidadCompra"];
if ($CantCompra!="") {
	$CantCompra1 = $CantCompra;
	$CostoCompra = $CantidadComp["TotalCompra"];
}
else
{
	$CantCompra1 = 0;
	$CostoCompra = 0;
}

$Existencia = $Cant;
$CostoTotal = $CostT + $CostoAlimentacion - $CostoTerminado + $CostoTT - $CostoTotalMortalidad + $CostoSumaTrasF + $CostoCompra;
$CostoUnitario = $CostoTotal / $Existencia;

//ingreso control
$SQL_INSERT_CONTROL = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET  Observaciones = '$Observaciones', CostoAlimentacion = '$CostoAlimentacion', PromedioLibra = '$PromedioLibra', CostoTerminado = '$CostoTerminado', UnidadesTraslado = '$TotalTraslado', CostoUTraslado = '$CostoU', CostoUTotalTraslado = '$CostoTT', UnidadesMortalidad = '$TotalMortalidad', CostoUMortalidad = '$CostoUMortalidad', CostoTotalMortalidad = '$CostoTotalMortalidad', PesoMortalidad = '$TotalPeso', TallaMortalidad = '$TotalTalla', TamanioMuestra = '$Tamanio', TotalMuestra = '$TotalMuestreo', Oxigeno = '$Oxigeno', PH = '$Ph', Temperatura = '$Temperatura', Amonio = '$Amonio', PesoMuestra = '$PesoF', TallaMuestra = '$TallaF', Existencia = '$Existencia', CostoUnitario = '$CostoUnitario', CostoTotal = '$CostoTotal', Colaborador = $id_user, FechaIngreso = CURRENT_TIMESTAMP WHERE Fecha = '$Fecha' and Estanque = '$NoEstanque'");
//Actualizar Inv 
$Inv = mysqli_query($db, "UPDATE Pisicultura.Estanque SET CantidadAct = $Existencia WHERE IdEstanque = $NoEstanque");
if($SQL_INSERT_CONTROL){ 
	echo '1';
}else { 
	echo '2';
}

?>	