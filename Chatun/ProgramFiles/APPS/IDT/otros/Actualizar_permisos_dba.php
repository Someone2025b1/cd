<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");


//recibe los datos para las base datos
$auxi=$_SESSION["cuenta_user"];//obtener usario
$iduser=$_GET["cif"];
$base=$_GET["base"];
$nivel=$_GET["nivel"];
$comen=$_GET["coment"];
$modifica=$_GET["modi"];
$ip = "IP $_SERVER[REMOTE_ADDR]"; //obtiene la ip 




 echo $fecha_actual = date("Y-m-d H:i:s"); 


 echo "-base  ".$base;
 echo " -agenc  ".$nivel;
 echo " -id de usuer  ".$iduser;
 echo " -comentario  ".$comen;
$sql4 = "select * from permisos where id_user='$iduser' and id_base='$base' "; //buscar el nombre de los usuarios
		$result_n4 = mysqli_query($db, $sql4);
		$row4=mysqli_fetch_array($result_n4);
		$vali=$row4["id_base"];
		echo "datos de vali".$vali;
		
		if ($vali == $base){ $enviar=1; echo "va vale ".$enviar;} else {
 
 $sql = "INSERT INTO coosajo_base_bbdd.permisos (id_permiso, id_user, id_base, activo, permiso, fecha_ingreso, fecha_baja, comentario) VALUES (NULL, '$iduser', '$base', '1', '$nivel', '$fecha_actual', '', '$comen');"; 
$result=mysqli_query($db, $sql); echo "va vale 0-";}
 
$sql9 = "INSERT INTO coosajo_base_bbdd.historial_modificacion_usuarios (id, cif_user, fecha, user_edit_cif, ip_conexion, cambios_realizado, base, nivel, comentario, base_estado, usuario_estado) VALUES ('', '$iduser', '$fecha_actual', '$auxi', '$ip', '$modifica', '$base','$nivel','$comen','1','1');";
$result9=mysqli_query($db, $sql9);

?>
<?php
//header ("Location: permisos_dba.php?cif=$iduser&va=$enviar"); arreglar lalala
ob_flush();
?>
<head>
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=permisos_dba.php?cif=<?php echo $iduser ?>&amp;va=<?php echo "".$enviar ?>">
</head>