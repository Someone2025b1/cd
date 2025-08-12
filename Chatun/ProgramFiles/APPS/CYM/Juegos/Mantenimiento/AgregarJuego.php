<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
  
$Id       = $_POST["Id"]; 
$IdCombo  = $_POST["IdCombo"];  
$sql = mysqli_query($db, "INSERT INTO Bodega.COMBO_DETALLE (Combo_Id,  P_CODIGO)
					VALUES ('".$IdCombo."', '".$Id."')");

if($sql)
{
	echo "1";							
} 
?>
					 