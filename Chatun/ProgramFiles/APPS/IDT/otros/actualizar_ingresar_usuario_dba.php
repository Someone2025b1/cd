<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//recibos las variables para las base datos
$auxi=$_SESSION["cuenta_user"];//obtener usario
$iduser=$_GET["cif"];
$nombre=$_GET["nombre"];
$depar=$_GET["Departamento"];
$agen=$_GET["Agencias"];
$log=$_GET["login"];
$pass=$_GET["password"];
$eje=$_GET["ejecu"];
$modifica=$_GET["modi"];
$grupo=$_GET["grupo"];
$fecha_actual = date("Y-m-d H:i:s"); 
$ip = "IP $_SERVER[REMOTE_ADDR]"; //obtiene la ip 



echo " cif:  ".$iduser;
echo "-nobre:  ".$nombre;
echo "-departa:   ".$depar;
echo "-agencia:  ".$agen;
echo "-login:  ".$log;
echo "-password:  ".$pass;
echo "-codigo de Ejecutiov".$eje;
echo "-fecha hoy: ".$fecha_actual;


$sql = "INSERT INTO coosajo_base_bbdd.usuarios (id_user, nombre, estado, depto, agencia, login, clave, grupo, fecha_ingreso, fecha_password, fecha_baja, codigo_ejecutivo) VALUES ('$iduser', '$nombre', '1', '$depar', '$agen', '$log', '$pass', '$grupo', '$fecha_actual', '$fecha_actual', '', '$eje');";
$result=mysqli_query($db, $sql);

$sql9 = "INSERT INTO coosajo_base_bbdd.historial_modificacion_usuarios (id, cif_user, fecha, user_edit_cif, ip_conexion, cambios_realizado, base, nivel, comentario, base_estado, usuario_estado) VALUES ('', '$iduser', '$fecha_actual', '$auxi', '$ip', '$modifica', '','','','','1');";
$result9=mysqli_query($db, $sql9);

?>
<?php
header ("Location: busqueda_modifi_usuarios_dba.php");
ob_flush();
?>
