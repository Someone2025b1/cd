<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//recibos las variables para las base datos
$auxi=$_SESSION["cuenta_user"];//obtener usario
$iduser=$_GET["iduser"];
$base=$_GET["base"];
$nivel=$_GET["nivel"];
$comen=$_GET["coment"];
$activo=$_GET["estatus"];
$modifica=$_GET["modi"];
$fecha_actual = date("Y-m-d H:i:s"); 
$ip = "IP $_SERVER[REMOTE_ADDR]"; //obtiene la ip  

echo "-base  ".$base;
 echo " -agenc  ".$nivel;
 echo " -id de usuer  ".$iduser;
 echo " -comentario  ".$comen;
 echo "  -Activo ".$activo;
 
 $sql = "UPDATE coosajo_base_bbdd.permisos SET activo = '$activo', permiso = '$nivel', fecha_baja = '$fecha_actual', comentario = '$comen' WHERE permisos.id_user = '$iduser' AND permisos.id_base = '$base' ;";
 $result=mysqli_query($db, $sql);
 
$sql9 = "INSERT INTO coosajo_base_bbdd.historial_modificacion_usuarios (id, cif_user, fecha, user_edit_cif, ip_conexion, cambios_realizado, base, nivel, comentario, base_estado, usuario_estado) VALUES ('', '$iduser', '$fecha_actual', '$auxi', '$ip', '$modifica', '$base','$nivel','$comen','$activo','1');";
$result9=mysqli_query($db, $sql9);

?>
<head>
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=permisos_dba.php?cif=<?php echo $iduser ?>">
</head>