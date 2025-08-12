<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$IdCombo = $_POST["IdCombo"];
?>
<div class="row">
	<div class="col-lg-6 col-lg-6">
		<div class="form-group">
			<?php 
			$Detalle = mysqli_query($db, "SELECT a.P_NOMBRE, a.P_CODIGO FROM Bodega.PRODUCTO a 
			WHERE a.CP_CODIGO = 'JG' AND NOT EXISTS (SELECT *FROM Bodega.COMBO_DETALLE b WHERE b.P_CODIGO = a.P_CODIGO AND b.Combo_Id = '$IdCombo') ORDER BY a.P_NOMBRE");
			while($row = mysqli_fetch_array($Detalle))
			{
				$Nombre = $row["P_NOMBRE"];
				$Id = $row["P_CODIGO"];
				 ?>
				 <div class="col-lg-6"> 
				 		<input readonly type="text" value="<?php echo $Nombre?>" class="form-control"> 
				 </div>
				  <div class="col-lg-6"> 
				 		<input type="checkbox" value="<?php echo $Id?>" class="form-control" onchange="GuardarJuego(this.value)"> 
				 </div>
				 <?php 
			}
			?> 
		</div>
	</div>
</div>