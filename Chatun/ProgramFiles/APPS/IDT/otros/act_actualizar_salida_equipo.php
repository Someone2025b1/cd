<?php 
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
					//el usuario que gestiona el proceso
					session_start();
				  	$user_graba=$_SESSION["cuenta_user"];
//Recibe las variables para ingreso
$idin=$_GET["id"];
$descripcion=$_GET["descri"];
$fecha_actual = date("Y-m-d H:i:s"); 
/*
$$sql = "UPDATE coosajo_inventario_idt.inventario_departamento SET Fecha_salida = '$fecha_actual', salida_colaborador_idt = '$user_graba', estado_actual = '0', descripcion_salida = '$descripcion' WHERE id='$idin' "; */
echo "id es :  ".$idin;
$sql = "UPDATE coosajo_inventario_idt.inventario_departamento SET estado_actual = '0', fecha_salida = '$fecha_actual', descripcion_salida = '$descripcion' WHERE inventario_departamento.id = '$idin' LIMIT 1;";
$result=mysqli_query($db, $sql);

?>
<?php
header ("Location: act_manejo_equipo.php");
ob_flush();
?>