<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
$CIF = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$CIF = $_POST["CIF"];
?> 
<div class="col-lg-6">
	<h3>Aplicativos</h3>
 <?php 
 $Aplicaciones = mysqli_query($db, "SELECT id_aplicacion, nombre 
FROM info_bbdd.aplicaciones_agg a
WHERE NOT EXISTS (SELECT *FROM info_bbdd.permisos_app b where b.id_aplicacion = a.id_aplicacion AND b.id_user = $CIF and b.estado = 1);");
 while ($RowApp = mysqli_fetch_array($Aplicaciones)) 
 {
  ?>
  <div class="row">
  	<div class="col-xs-4"><?php echo $RowApp["nombre"]; ?></div>
  	<div class="col-xs-2"><input type="checkbox" onchange="AgregarAplicativo(1,'<?php echo $RowApp["id_aplicacion"]?>', '<?php echo $CIF ?>')"></div>
  </div>
  <?php 
 }
 ?>
</div>
<div class="col-lg-6">
	<h3>Aplicativos Asignados</h3>
 <?php 
 $Aplicaciones1 = mysqli_query($db, "SELECT id_aplicacion, nombre 
FROM info_bbdd.aplicaciones_agg a
WHERE EXISTS (SELECT *FROM info_bbdd.permisos_app b where b.id_aplicacion = a.id_aplicacion AND b.id_user = $CIF and b.estado = 1)");
 while ($RowApp1 = mysqli_fetch_array($Aplicaciones1)) 
 {
  ?>
  <div class="row">
  	<div class="col-xs-4"><?php echo $RowApp1["nombre"]; ?></div>
  	<div class="col-xs-2"><i class="text-danger" onclick="AgregarAplicativo(2,'<?php echo $RowApp1["id_aplicacion"]?>', '<?php echo $CIF ?>')">X</i></div>
  </div>
  <?php 
 }
 ?>
</div>  