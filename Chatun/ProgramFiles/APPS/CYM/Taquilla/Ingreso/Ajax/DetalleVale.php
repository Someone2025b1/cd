 
<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Hotel = $_POST["Hotel"];
$Query = mysqli_query($db, "SELECT a.DAV_VALE FROM Taquilla.DETALLE_ASIGNACION_VALE  a 
INNER JOIN  Taquilla.ASIGNACION_TALONARIO_TICKET b ON a.ATT_CODIGO = b.ATT_CODIGO
WHERE b.H_CODIGO = $Hotel AND a.DAV_ESTADO = 1
 ");
?>
<select class="form-control" id="vale" name="vale">
	<option selected="" disabled="">Seleccione</option>
	<?php 
	while ($Row = mysqli_fetch_array($Query)) 
	{
	 	?>
	 	<option value="<?php echo $Row["DAV_VALE"] ?>"><?php echo $Row["DAV_VALE"] ?></option>
	 	<?php 
	 } ?>
</select>