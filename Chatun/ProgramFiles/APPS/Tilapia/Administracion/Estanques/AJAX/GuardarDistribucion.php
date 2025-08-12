<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$IdT = $_POST["Id"];
$Fecha = $_POST["Fecha"];
$Estanque = $_POST["Estanque"];
$Cantidad = $_POST["Cantidad"]; 
$FechaAnt      = date("Y-m-d",strtotime($Fecha."- 1 days"));
$Select = mysqli_fetch_array(mysqli_query($db, "SELECT  a.Cantidad, a.Producto, a.Precio, a.Id FROM Bodega.COMPRA_ALEVINES a  
WHERE a.TRA_CODIGO = '".$IdT."'"));
$Id = $Select["Id"];
$Producto = $Select["Producto"];  
$Disponible = $Select["Cantidad"];  
$Precio = $Select["Precio"];
$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.DISTRIBUCION_ALEVINES (Producto, Cantidad, Precio, Fecha, FechaIngreso, IdCompra, Usuario) 
VALUES ('$Producto', '$Disponible', '$Precio', '$Fecha', CURRENT_TIME, $Id , '$id_user')");
$IdDetalle = mysqli_insert_id($db);
$Contador = count($Cantidad);
$PrecioUnitario = $Precio / $Disponible;
for ($i=0; $i < $Contador; $i++) { 
	 $SQL_INSERT1 = mysqli_query($db, "INSERT INTO Bodega.DETALLE_DISTRIBUCION_ALEVINES (IdDistribucion, NoEstanque, Cantidad) 
VALUES ('$IdDetalle', '$Estanque[$i]', '$Cantidad[$i]')");
	 $TotalCosto = $PrecioUnitario * $Cantidad[$i];
	 //valido si ya se hizo el control en el estanque a ingresar los alevines

		$Contar = mysqli_num_rows(mysqli_query($db, "SELECT * FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$Estanque[$i]'"));
		if ($Contar==0) 
		{ 
		$ConteoExi = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$Estanque[$i]'"));
			if ($ConteoExi==0) 
			{
				$CantInicial = mysqli_fetch_array(mysqli_query($db, "SELECT A.InventarioInicial, A.CostoTotal, A.CostoUnitario FROM Pisicultura.Estanque A WHERE A.IdEstanque = $Estanque[$i]"));
				 $TotalExi = $CantInicial["InventarioInicial"];
				 $CostoFin = $CantInicial["CostoTotal"];  
			}
			else
			{
				$Total = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia, a.CostoUnitario, a.CostoTotal FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$FechaAnt' AND a.Estanque = '$Estanque[$i]'")); 
				$CostoFin = $TotalCos["CostoTotal"]; 
				$TotalExi = $Total["Existencia"]; 
			}  
			$Exi = $TotalExi + $Cantidad[$i];
			$CostoIns = $CostoFin + $TotalCosto;
			$CostoUF = $CostoIns / $Exi;
		 	$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.CONTROL_PISICULTURA (Fecha, Estanque, CantidadCompra, CostoUCompra, TotalCompra, Existencia, CostoUnitario, CostoTotal) 
			VALUES ('$Fecha', '$Estanque[$i]', $Cantidad[$i], $PrecioUnitario, $TotalCosto, $Exi, $CostoUF, $CostoIns)");
		} 
		else
		{
		$Total = mysqli_fetch_array(mysqli_query($db, "SELECT a.Existencia, a.CostoUnitario, a.CostoTotal, a.CantidadCompra, a.CostoUCompra, a.TotalCompra FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$Estanque[$i]'"));
		$UniT = $Cantidad[$i] + $Total["CantidadCompra"];
		$CostoUT = $PrecioUnitario + $Total["CostoUCompra"];
		$CostoUTT = $TotalCosto + $Total["TotalCompra"];
		$ExistenciaT = $Total["Existencia"] + $Cantidad[$i]; 
		$CostoTF = $Total["CostoTotal"] + $TotalCosto;
		$CostoUF = $CostoTF / $ExistenciaT;
		
		$SQL_INSERT_CONTROL = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET CantidadCompra = '$Cantidad[$i]', CostoUCompra = '$PrecioUnitario', TotalCompra = '$TotalCosto', Existencia = '$ExistenciaT', CostoUnitario = '$CostoUF', CostoTotal = '$CostoTF' WHERE Fecha = '$Fecha' and Estanque = $Estanque[$i]");
		//modificar todos los valores en cuestion de existencias y costos finales
		$ControlesPosteriores = mysqli_query($db, "SELECT a.Id, a.Existencia, a.CostoTotal  FROM Bodega.CONTROL_PISICULTURA a WHERE a.Estanque = $Estanque[$i] and a.Fecha > '$Fecha'");
			while ($Upd = mysqli_fetch_array($ControlesPosteriores)) 
			{
			   $ExistenciaF = $Upd["Existencia"] + $Cantidad[$i];
			   $CostoTotalUp = $Upd["CostoTotal"] + $TotalCosto;
			   $CostoUpd = $CostoTotalUp / $ExistenciaF;
			   $Upd = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET Existencia = $ExistenciaF, CostoUnitario = $CostoUpd, CostoTotal = $CostoTotalUp WHERE Id = $Upd[Id]");
			}
		}	

}
if($SQL_INSERT){
	$Upd = mysqli_query($db, "UPDATE Bodega.COMPRA_ALEVINES SET Estado = 2 where Id = $Id");
	echo '1';
}else {

	echo '2';
}

?>	