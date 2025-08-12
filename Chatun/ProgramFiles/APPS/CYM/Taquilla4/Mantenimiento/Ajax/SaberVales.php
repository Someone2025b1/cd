<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$talonario = $_POST["Id"];
?>
<div class="row">
<div class="col-lg-2">
	<div class="form-group">
		<select id="vale" name="vale" class="form-control" >
			<option selected="" disabled="">Seleccione</option>
			<?php 
			$QuerySelect = mysqli_query($db, "SELECT A.DAV_VALE  FROM Taquilla.DETALLE_ASIGNACION_VALE A WHERE A.DAV_ESTADO = 1 AND A.ATT_CODIGO = '$talonario'");
			while ($Row = mysqli_fetch_array($QuerySelect)) 
			{
			?>
			<option value="<?php echo $Row[DAV_VALE] ?>"><?php echo $Row[DAV_VALE] ?></option>
			<?php 
			}
			?>
		</select>
		<label for="Del">Vale</label>
	</div>
</div>
</div>