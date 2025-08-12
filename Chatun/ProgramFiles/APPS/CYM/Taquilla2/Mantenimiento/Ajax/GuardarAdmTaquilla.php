<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$tipo = $_POST["tipo"];

switch ($tipo) {
	case '1':
		$nombrePrograma = $_POST["nombrePrograma"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.PROGRAMAS_ACTIVOS(PA_DESCRIPCION, PA_ESTADO)
VALUES('$nombrePrograma', 1)");
		
	case '2':
		$nombreClasificador = $_POST["nombreClasificador"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.CLASIFICADOR_EVENTO(CE_DESCRIPCION, CE_ESTADO)
VALUES('$nombreClasificador', 1)");
		
	case '3':
		$eventoCortesia = $_POST["eventoCortesia"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.EVENTO(E_DESCRIPCION, E_ESTADO, E_TIPO)
VALUES('$eventoCortesia', 1, 2)");
		
	case '4':
		$eventos = $_POST["eventos"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.EVENTO(E_DESCRIPCION, E_ESTADO, E_TIPO)
VALUES('$eventos', 1, 1)");
		
	case '5':
		$referenciaTipo = $_POST["referenciaTipo"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.TIPO_REFERENCIA(TR_DESCRIPCION, TR_ESTADO)
VALUES('$referenciaTipo', 1)");
		
	case '6':
		$nombreArea = $_POST["nombreArea"];
		$insert = mysqli_query($db, "INSERT INTO Taquilla.AREA_UTILIZAR(AU_DESCRIPCION, AU_ESTADO)
VALUES('$nombreArea', 1)");
		
	
	default:
		# code...
		
} 


if($insert){
    echo "1";
}
?>