<meta charset="utf-8">
<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/httpful.phar");


$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$TIT = $_POST["TIT"];


?> 
<meta charset="utf-8">
<div class="col-lg-6">
<h3>Nomenclaturas Disponibles</h3>
<input type="text" name="Buscador" id="Buscador" placeholder="Buscar...">
<?php 
$Aplicaciones = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE 
FROM Finanzas.NOMENCLATURA A
WHERE A.T_CODIGO = 0");
while ($RowApp = mysqli_fetch_array($Aplicaciones)) 
{
?>
<div class="buscar">
<div class="row">
    <div class="col-xs-4"><?php echo $RowApp["N_CODIGO"]; ?></div>
    <div class="col-xs-4"><?php echo $RowApp["N_NOMBRE"]; ?></div>
    <div class="col-xs-2"><input type="checkbox" onchange="AgregarNomenclatura('<?php echo $RowApp['N_CODIGO']?>', '<?php echo $TIT ?>')"></div>
</div>
</div>
<?php 
}
?>
</div>
<div class="col-lg-6">
    <h3>Nomenclaturas Asignadas</h3>
<?php 

$Aplicaciones1 = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE 
FROM Finanzas.NOMENCLATURA A
WHERE A.T_CODIGO=$TIT");
while ($RowApp1 = mysqli_fetch_array($Aplicaciones1)) 
{
?>
<div class="row">
    <div class="col-xs-3"><?php echo $RowApp1["N_CODIGO"]; ?></div>
    <div class="col-xs-3"><?php echo $RowApp1["N_NOMBRE"]; ?></div>
    <div class="col-xs-2"><a class="text-danger" onclick="AgregarNomenclatura('<?php echo $RowApp1['N_CODIGO']?>', 0)">X</a></div>

</div>
<?php 
}
?>
</div>