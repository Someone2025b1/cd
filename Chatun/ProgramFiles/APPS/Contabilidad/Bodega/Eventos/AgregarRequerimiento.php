<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


$Cantidad  = $_POST["Cantidad"];
$Producto  = $_POST["Producto"];
$FechaEsperada = $_POST['FechaEsperada'];
$FechaLimite = $_POST['FechaLimite'];
$CodigoDelTiempo = $_POST['CodigoDelTiempo'];
$CodigoEv = $_POST['CodigoEv'];
$Observaciones = $_POST['Observaciones'];
$Borrar = $_POST['Borrar'];
$Contador  = count($_POST["Cantidad"]);

if($Borrar==1){

$sql1 = mysqli_query($db,"DELETE FROM Eventos.EV_PRODUCTOS_AYB WHERE EV_CODIGO = '$CodigoEv' AND EV_CODIGO_REQUERIMIENTO = '$CodigoDelTiempo'");

}

$queryRequerimiento = mysqli_query($db, "INSERT INTO Eventos.EV_PRODUCTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EV_CANTIDAD, P_CODIGO, EV_FECHA_ESPERADA, EV_FECHA_SOLICITO, EV_HORA_PEDIDO, EV_FECHA_LIMITE, EV_ESTADO, EV_OBSERVACIONES_AYB)
VALUES('".$CodigoEv."', '".$CodigoDelTiempo."', '".$Cantidad."', '".$Producto."', '".$FechaEsperada."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$FechaLimite."', 0, '".$Observaciones."')");


					


		if($queryRequerimiento)
		{
			echo "1";
		}
?>
