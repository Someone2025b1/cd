<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//session_start();
//$user_graba=$_SESSION["cuenta_user"];				  	
					
//donde se recibe los datos para ingresar a la base de datos
$auxi=$_SESSION["cuenta_user"];//obtener usario
$nombre=$_GET["nombre"];
$depto=$_GET["Departamento"];
$opcio=$_GET["estados"];
$agen=$_GET["Agencias"];
$iduser=$_GET["cif"];
$passw=$_GET["pass"];
$log=$_GET["login"];
$eje=$_GET["ejecu"];
$grupo=$_GET["grupo"];
$iduser_cif=$_GET["datos"];
$modifica=$_GET["modi"];
$ip = "IP $_SERVER[REMOTE_ADDR]"; //obtiene la ip 


 echo $fecha_actual = date("Y-N-d H:i:s"); 
 /*
 echo "campo1  ".$nombre;
 echo "depart  ".$depto;
 echo "opcion de estado ES=   ".$opcio;
 echo " -agenc  ".$agen;
 echo "cuenta cambiar  ".$iduser;
 echo "password  ".$passw;
 echo "fecha  ".$fecha_actual;
 echo "cif oculto: ".$iduser_cif;
 echo "-login  ".$log;
 echo "login quien graba cuenta:   ".$auxi; */

 
if ($opcio == 0) {
 $sql = "UPDATE coosajo_base_bbdd.usuarios SET estado = '$opcio', id_user = '$iduser', nombre = '$nombre', depto = '$depto', agencia = '$agen', login = '$log', clave = '$passw', grupo = '$grupo',  fecha_password = '$fecha_actual', fecha_baja = '$fecha_actual', codigo_ejecutivo = '$eje' WHERE usuarios.id_user ='$iduser_cif' ;";
$result=mysqli_query($db, $sql);
echo "aqui paso en 0"; } else {
	
$sql = "UPDATE coosajo_base_bbdd.usuarios SET estado = '$opcio', id_user = '$iduser',  nombre = '$nombre', depto = '$depto', agencia = '$agen', login = '$log', clave = '$passw', grupo = '$grupo', fecha_password ='$fecha_actual', codigo_ejecutivo = '$eje'  WHERE usuarios.id_user ='$iduser_cif' ;";
$result=mysqli_query($db, $sql); }

if ($iduser != $iduser_cif)  {
	
$sql8 = "UPDATE coosajo_base_bbdd.permisos SET id_user = '$iduser' WHERE permisos.id_user = '$iduser_cif' ";
	$result8=mysqli_query($db, $sql8);
	echo "cambio en cif en permisos:  ".$iduser;
}
$sql9 = "INSERT INTO coosajo_base_bbdd.historial_modificacion_usuarios (id, cif_user, fecha, user_edit_cif, ip_conexion, cambios_realizado, base, nivel, comentario, base_estado, usuario_estado) VALUES ('', '$iduser_cif', '$fecha_actual', '$auxi', '$ip', '$modifica', '','','','','$opcio');";
$result9=mysqli_query($db, $sql9);

?>
<?php
header ("Location: busqueda_modifi_usuarios_dba.php");
ob_flush();
?>
